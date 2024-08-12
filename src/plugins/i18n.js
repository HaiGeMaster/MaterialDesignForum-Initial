import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from '@/assets/language/language.js'
Vue.use(VueI18n)
function loadLocaleMessages () {
  const locales = require.context('./', true, /[A-Za-z0-9-_,\s]+\.json$/i)
  const messages = {}
  locales.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i)
    if (matched && matched.length > 1) {
      const locale = matched[1]
      messages[locale] = locales(key)
    }
  })
  return messages
}
function GetFirstLangCodeList(){
  for (let langCode in messages) {
    if(messages[langCode].Message.usability){
      return langCode;
    }
  }
}
//Vue.prototype.$G_GetFirstLangCodeList = GetFirstLangCodeList;
export default new VueI18n({
  // locale: process.env.VUE_APP_I18N_LOCALE || 'en',
  // fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
  //locale: 'zh_CN',
  locale: GetFirstLangCodeList(),//'zh_TW',
  fallbackLocale:  GetFirstLangCodeList(),//process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'zh_TW',
  messages,//: loadLocaleMessages()
})
