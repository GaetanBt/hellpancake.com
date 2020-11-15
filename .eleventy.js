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



  /**
   * Output configuration
   */

  return {
    dir: {
      input: 'src'
    }
  }
}
