module.exports = function (eleventyConfig) {
  eleventyConfig.setQuietMode()

  eleventyConfig.addPassthroughCopy('src/assets')

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
