module.exports = {
  eleventyComputed: {
    eleventyNavigation: {
      parent: data => data.eleventyNavigation.parent || 'Articles',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
