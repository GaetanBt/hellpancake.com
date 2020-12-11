module.exports = {
  layout: 'templates/post',
  eleventyComputed: {
    opengraph: {
      type: 'article'
    },
    eleventyNavigation: {
      parent: data => data.eleventyNavigation.parent || 'Posts',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
