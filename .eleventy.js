const eleventyNavigationPlugin = require('@11ty/eleventy-navigation')

const site = require('./src/_data/site')
const config = require('./src/_data/config')
const locales = require('./src/_data/locales')

module.exports = function (eleventyConfig) {

  /**
   * Configurations
   */

  eleventyConfig.setQuietMode()

  // Because we no longer parse these files with 11ty, it cannot refresh the browser on changes
  eleventyConfig.setBrowserSyncConfig({
    files: [ '_site/assets/*.css', '_site/assets/*.js' ]
  })



  /**
   * Assets
   */

  eleventyConfig
    .addPassthroughCopy('src/assets/**/*.!(css)')
    .addPassthroughCopy('src/*.!(json)')



  /**
   * Plugins
   */

  eleventyConfig.addPlugin(eleventyNavigationPlugin)



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
   * Helpers
   */

  function getDefaultLocale () {
    for (const [key, value] of Object.entries(site.locales)) {
      if (value.default === true) {
        return key
      }
    }
  }

  function getAvailableLocales () {
    return Object.keys(site.locales)
  }



  /**
   * Filters
   */

  eleventyConfig.addFilter('absoluteUrl', function (path) {
    return new URL(path, site.url)
  })

  eleventyConfig.addFilter('pagePermalink', function (page) {
    const path = page.filePathStem.split('/')
    const defaultLocale = getDefaultLocale()
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

    getAvailableLocales().forEach(availableLocale => {
      const {
        code,
        displayName
      } = site.locales[availableLocale]

      let url = code === getDefaultLocale() ? '/' : `/${code}`

      if (currentTranslationKey) {
        for (let page of pages) {
          if (currentTranslationKey === page.data.translationKey && code === page.data.locale) {
            url = page.url
          }
        }
      } else {
        if (currentLocale === code) {
          url = currentUrl
        }
      }

      changelang.push({
        url: url,
        label: displayName,
        isActive: currentLocale === code,
        targetLocale: code
      })
    })

    return changelang
  })

  eleventyConfig.addFilter('prefixWithBaseUrl', function (str) {
    const currentLocale = this.ctx.locale

    if (config.excludeDefaultLocaleFromUrl === true && getDefaultLocale() === currentLocale) {
      return `/${str}`
    }

    return `/${currentLocale}/${str}`
  })

  /* @see https://stackoverflow.com/questions/6393943/convert-javascript-string-in-dot-notation-into-an-object-reference#answer-6394168 */
  eleventyConfig.addFilter('translate', function (key) {
    const locale = this.ctx.locale

    if (!locales.hasOwnProperty(locale)) {
      throw new Error(`[translate]: Translation's locale \`${locale}\` does not exist`)
    }

    key = `${locale}.${key}`

    const translation = key.split('.').reduce((acc, i) => acc[i], locales)

    if (typeof translation === 'undefined') {
      throw new Error(`[translate]: No translation found for key \`${key}\``)
    }

    return translation
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

  eleventyConfig.addPairedShortcode("code", function (content, language) {
    return `
      <div class="Code m-0">
        <div class="Code-language text-bold">${language}</div>
        <div class="Code-example">
          <pre class="my-0"><code>${content}</code></pre>
        </div>
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
