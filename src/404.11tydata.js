const helpers = require('./_data/helpers')
const locale = helpers.getDefaultLocale()

module.exports = {
  meta: {
    title: helpers.translate('404.title', locale),
    robots: {
      index: 'noindex',
      follow: 'nofollow'
    }
  },
  locale: locale,
  eleventyExcludeFromCollections: true,
  excludeFromXMLSitemap: true
}
