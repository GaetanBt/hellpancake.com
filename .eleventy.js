const eleventyNavigationPlugin = require('@11ty/eleventy-navigation')

const site = require('./src/_data/site')

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

  eleventyConfig.addPassthroughCopy('src/assets/**/*.!(css)')



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



  /**
   * Output configuration
   */

  return {
    dir: {
      input: 'src'
    }
  }
}
