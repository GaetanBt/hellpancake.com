const site = require('./_data/site.json')

module.exports = {
  layout: 'templates/default',
  eleventyComputed: {
    author: data => data.author || site.author,
  },
  opengraph: {
    type: 'website'
  }
}
