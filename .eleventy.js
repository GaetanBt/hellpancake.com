module.exports = function (eleventyConfig) {
  eleventyConfig.setQuietMode()

  eleventyConfig.addPassthroughCopy('src/assets/**/*.!(css)')

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

  // Because we no longer parse these files with 11ty, it cannot refresh the browser on changes
  eleventyConfig.setBrowserSyncConfig({
    files: [ '_site/assets/*.css', '_site/assets/*.js' ]
  })

  return {
    dir: {
      input: 'src'
    }
  }
}
