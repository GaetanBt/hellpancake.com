module.exports = {
  plugins: [
    require('autoprefixer'),
    require('cssnano')({
      preset: 'default'
    }),
    /* @see https://brycewray.com/posts/2020/11/using-postcss-cache-busting-eleventy/ */
    require('postcss-hash')({
      trim: 20,
      manifest: './src/_data/manifest.json'
    })
  ]
}
