const eleventyNavigationPlugin = require('@11ty/eleventy-navigation')

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
   * Filters
   */

  eleventyConfig.addFilter('pagePermalink', function (page) {
    const path = page.filePathStem.split('/')
    const excludeFromPath = ['pages']

    // Index pages should not be included in a `index` folder but at the root of the lang folder
    if (path[path.length - 1] === 'index') {
      excludeFromPath.push('index')
    }

    return path
      .filter(pathFragment => !excludeFromPath.includes(pathFragment))
      .join('/') + '/index.html'
  })

  return {
    dir: {
      input: 'src'
    }
  }
}
