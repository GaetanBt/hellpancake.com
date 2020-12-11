module.exports = {
  layout: 'templates/post',
  eleventyComputed: {
    opengraph: {
      type: 'article'
    },
    eleventyNavigation: {
      parent: data => data.eleventyNavigation.parent || 'Articles',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
