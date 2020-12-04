const site = require('../../../_data/site.json')

module.exports = {
  eleventyComputed: {
    author: data => data.author || site.author,
    eleventyNavigation: {
      parent: data => data.eleventyNavigation.parent || 'Articles',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
