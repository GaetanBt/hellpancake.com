module.exports = {
  eleventyComputed: {
    eleventyNavigation: {
      parent: 'Articles',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
