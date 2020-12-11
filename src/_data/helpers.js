const site = require('./site')
const config = require('./config')
const locales = require('./locales')

module.exports = {
  getDefaultLocale: function () {
    for (const [key, value] of Object.entries(site.locales)) {
      if (value.default === true) {
        return key
      }
    }
  },
  getAvailableLocales: function () {
    return Object.keys(site.locales)
  },
  translate: function (key, targetedLocale, token = null) {
    const locale = targetedLocale

    if (!locales.hasOwnProperty(locale)) {
      throw new Error(`[translate]: Translation's locale \`${locale}\` does not exist`)
    }

    key = `${locale}.${key}`

    const translation = key.split('.').reduce((acc, i) => acc[i], locales)

    if (typeof translation === 'undefined') {
      throw new Error(`[translate]: No translation found for key \`${key}\``)
    }

    if (token !== null) {
      return translation.replace('[[token]]', token)
    }

    return translation
  },
  prefixWithBaseUrl: function (str, targetLocale) {
    if (config.excludeDefaultLocaleFromUrl === true && this.getDefaultLocale() === targetLocale) {
      return `/${str}`
    }

    return `/${targetLocale}/${str}`
  }
}
