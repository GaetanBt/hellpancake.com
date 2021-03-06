const eleventyNavigationPlugin = require('@11ty/eleventy-navigation')
const eleventySyntaxHighlight = require('@11ty/eleventy-plugin-syntaxhighlight')

const site = require('./src/_data/site')
const helpers = require('./src/_data/helpers')

module.exports = function (eleventyConfig) {

  /**
   * Configurations
   */

  eleventyConfig.setQuietMode()
  eleventyConfig.setDataDeepMerge(true)

  // Because we no longer parse these files with 11ty, it cannot refresh the browser on changes
  eleventyConfig.setBrowserSyncConfig({
    files: [ '_site/assets/*.css', '_site/assets/*.js' ]
  })



  /**
   * Assets
   */

  eleventyConfig
    .addPassthroughCopy('src/assets/**/*.!(css)')
    .addPassthroughCopy({ 'src/root': '/' })



  /**
   * Plugins
   */

  eleventyConfig.addPlugin(eleventyNavigationPlugin)
  eleventyConfig.addPlugin(eleventySyntaxHighlight)



  /**
   * Collections
   */

  /**
   *  Add locale relative collections
   *  @note gives access to `collections[locale]` collections
   */

  Object.keys(site.locales).forEach(locale => {
    eleventyConfig.addCollection(locale, function (collectionApi) {
      return collectionApi.getFilteredByGlob(`src/pages/${locale}/**/*.*`)
    })
  })

  eleventyConfig.addCollection('posts_en', function (collectionApi) {
    return collectionApi.getFilteredByGlob('src/pages/en/posts/**/*.md')
  })

  eleventyConfig.addCollection('posts_fr', function (collectionApi) {
    return collectionApi.getFilteredByGlob('src/pages/fr/articles/**/*.md')
  })



  /**
   * Filters
   */

  eleventyConfig.addFilter('absoluteUrl', function (path) {
    return new URL(path, site.url)
  })

  eleventyConfig.addFilter('pagePermalink', function (page) {
    const path = page.filePathStem.split('/')
    const defaultLocale = helpers.getDefaultLocale()
    const excludeFromPath = ['pages', defaultLocale]

    // Index pages should not be included in a `index` folder but at the root of the lang folder
    if (path[path.length - 1] === 'index') {
      excludeFromPath.push('index')
    }

    return path
      .filter(pathFragment => !excludeFromPath.includes(pathFragment))
      .join('/') + '/index.html'
  })

  eleventyConfig.addFilter('getFeedPermalink', function (locale) {
    return `feed-${locale}.xml`
  })

  eleventyConfig.addFilter('changelang', function (pages, currentUrl, currentLocale) {
    const currentTranslationKey = this.ctx.translationKey
    const changelang = []

    helpers.getAvailableLocales().forEach(availableLocale => {
      const {
        code,
        displayName
      } = site.locales[availableLocale]

      const data = {}
      const isActive = currentLocale === code
      let url = helpers.prefixWithBaseUrl('', code)

      if (currentTranslationKey) {
        for (let page of pages) {
          if (currentTranslationKey === page.data.translationKey && code === page.data.locale) {
            url = page.url

            if (!isActive) {
              data.titleAttr = helpers.translate('changelang.pageAvailableIn', code)
            }
          }
        }
      } else {
        if (currentLocale === code) {
          url = currentUrl
        }

        if (!isActive) {
          data.titleAttr = helpers.translate('changelang.pageNotAvailableIn', code)
        }
      }

      data.url = url
      data.label = displayName
      data.isActive = isActive
      data.targetLocale = code

      changelang.push(data)
    })

    return changelang
  })

  eleventyConfig.addFilter('prefixWithBaseUrl', function (str, targetLocale = null) {
    const currentLocale = targetLocale || this.ctx.locale
    return helpers.prefixWithBaseUrl(str, currentLocale)
  })

  /* @see https://stackoverflow.com/questions/6393943/convert-javascript-string-in-dot-notation-into-an-object-reference#answer-6394168 */
  eleventyConfig.addFilter('translate', function (key, token = null) {
    return helpers.translate(key, this.ctx.locale, token)
  })

  eleventyConfig.addFilter('localizeDate', function (date = null) {
    const locale = this.ctx.locale

    if (date === null) {
      throw new Error('[localizedDate]: no date provided')
    }

    const options = {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    }

    return new Intl.DateTimeFormat(locale, options).format(date)
  })

  eleventyConfig.addFilter('createDateObj', function (str) {
    return new Date(str)
  })

  eleventyConfig.addFilter('toISOString', function (date) {
    return date.toISOString()
  })

  eleventyConfig.addFilter('removeTimeFromISOString', function (ISOString) {
    return ISOString.split('T')[0]
  })

  eleventyConfig.addFilter('getLastUpdatedDate', function (collection) {
    const dates = []

    collection.forEach(item => {
      let created = item.date
      let lastUpdated = item.data.lastUpdated

      dates.push(created)

      if (lastUpdated) {
        if (typeof lastUpdated === 'string') {
          lastUpdated = new Date(lastUpdated)
        }

        dates.push(lastUpdated)
      }
    })

    return new Date(Math.max(...dates)).toISOString()
  })



  /**
   * Shortcodes
   */

  eleventyConfig.addPairedShortcode("code", function (content, params) {
    const languageKey = params.split(' ')[0]

    const displayName = {
      css: 'CSS',
      html: 'HTML',
      js: 'JavaScript'
    }

    return `
      <div class="Code">
        <div class="Code-language text-bold">${displayName[languageKey] || languageKey}</div>
        <div class="Code-example">
          ${eleventyConfig.nunjucksPairedShortcodes.highlight(content, params)}
        </div>
      </div>
    `.trim()
  });

  eleventyConfig.addPairedShortcode("note", function (content, type = 'info', htmlClass = '') {
    const classes = ['Note', `Note--${type}`]

    if (htmlClass !== '') {
      classes.push(htmlClass)
    }

    return `
      <div class="${classes.join(' ')}">
        ${content}
      </div>
    `
  });



  /**
   * Output configuration
   */

  return {
    markdownTemplateEngine: 'njk',
    htmlTemplateEngine: 'njk',

    dir: {
      input: 'src'
    }
  }
}
