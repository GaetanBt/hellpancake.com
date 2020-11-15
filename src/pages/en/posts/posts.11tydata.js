module.exports = {
  eleventyComputed: {
    eleventyNavigation: {
      parent: 'Posts',
      title: data => data.meta.title,
      excerpt: data => data.excerpt
    }
  }
}
