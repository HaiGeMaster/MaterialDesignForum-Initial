<template>
  <v-tooltip bottom :disabled="LanguageMenu">
    <template v-slot:activator="{ on: on1, attrs: attrs1 }">
      <v-menu offset-y v-model="LanguageMenu" :rounded="$store.getters.App.Style.rounded">
        <template v-slot:activator="{ on: on2, attrs: attrs2 }">
          <v-btn icon v-show="show&&LanguageList.length>=2" v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)">
            <v-icon>mdi-translate</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-list class="">
            <v-list-item-group :style="`overflow-y: auto;max-height: 300px;`">
              <v-list-item v-for="(item, i) in LanguageList"
              :class="item.locale == $i18n.locale?'v-item--active v-list-item--active':''"
              :disabled="!item.usability"
              :key="`LanguageButton_${i}`"
              @click="SetLanguage(item.locale, true)">
                <v-list-item-title
                >{{ item.text }}</v-list-item-title>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
        
      </v-menu>
    </template>
    <span>Language: {{ $t('Message.langname') }}</span>
  </v-tooltip>
</template>
<script>
import messages from '@/assets/language/language.js'
export default {
  name: 'language-button',
  props:{
    show: {
      type: Boolean,
      default: true,
    },
  },
  data(){
    return{
      LanguageMenu: false,
      LanguageList: [],
      IsMounted:false,
    }
  },
  methods:{
    SetLocaleCode(val){
      if(this.ValForLanguageList(val)){
        document.querySelector('html').setAttribute('lang', val)
        localStorage.setItem('lang', val)
        this.$cookies.set(`lang`,val)
        this.$i18n.locale = val
      }
      //确定messages中有这个语言
      // if(!messages.hasOwnProperty(val)){
      //   this.$router.push({ path: `/` })
      //   //路由回到默认语言
      //   //this.SetLanguage(this.$i18n.fallbackLocale,true)
      //   return
      // }
    },
    SetLanguageList() {
      for (let langCode in messages) {
        if(messages[langCode].Message.show){
          const langName = messages[langCode].Message.langname
          const usabilitys = messages[langCode].Message.usability
          this.LanguageList.push({ text: langName, locale: langCode, usability: usabilitys })
        }
      }
    },
    SetLanguage(val, UpdateRoute = false) {
      if(val==this.$i18n.locale){
        return
      }
      
      this.SetLocaleCode(val)
      if (UpdateRoute&&this.ValForLanguageList(val)) {
        this.SetRouteLang(val)
      }
    },
    SetRouteLang(lang){
      var pathArray = this.$route.path.split('/')
      var hash = this.$route.hash
      ////console.log(pathArray)
      if(this.$route.params.hasOwnProperty('lang')){//有lang,lang/xxx,lang/xxx/xxx
        ////console.log('this.$route.params.hasOwnProperty(lang)')
        if(pathArray.length==5){
          this.$router.push({ path: `/${lang}/${pathArray[2]}/${pathArray[3]}/${pathArray[4]}${hash}` })
        }else if(pathArray.length==4){
          this.$router.push({ path: `/${lang}/${pathArray[2]}/${pathArray[3]}${hash}` })
        }else if(pathArray.length==3){
          this.$router.push({ path: `/${lang}/${pathArray[2]}${hash}` })
        }else{
          this.$router.push({ path: `/${lang}/` })
        }
      }else{//沒有lang,/,/xxx,/xxx/xxx
        ////console.log('else')
        if(pathArray.length==4){
          this.$router.push({ path: `/${lang}/${pathArray[1]}/${pathArray[2]}/${pathArray[3]}${hash}` })
        }else if(pathArray.length==3){
          this.$router.push({ path: `/${lang}/${pathArray[1]}/${pathArray[2]}${hash}` })
        }else if(pathArray.length==2){
          this.$router.push({ path: `/${lang}/${pathArray[1]}${hash}` })
        }else{
          this.$router.push({ path: `/${lang}/` })
        }
        
      }
    },
    ValForLanguageList(val){
      for (let i = 0; i < this.LanguageList.length; i++) {
        if(this.LanguageList[i].locale == val){
          return true
        }
      }
      return false
    },
    SetLanguageAsLocale() {
      //console.log(this.$route.params.hasOwnProperty('lang'))
      if(this.$route.params.hasOwnProperty('lang')){//如果路由有lang参数，就用路由的lang参数来设置语言
        //console.log('this.$route.params.hasOwnProperty(lang)')
        var lang = this.$route.params.lang
        if(this.ValForLanguageList(lang)){
          this.SetLocaleCode(lang)
        }
      }else{//如果路由没有lang参数，就用localStorage的lang参数来设置语言，如果localStorage也没有，就用默认的首个语言
        //console.log('else')
        var locale = localStorage.getItem('lang')||document.querySelector('html').getAttribute('lang')||this.$i18n.fallbackLocale
        if(this.ValForLanguageList(locale)){
          //console.log(`this.ValForLanguageList(${locale})`)
          this.SetLocaleCode(locale)
        }
        //console.log(`this.ValForLanguageList(${locale})`)
      }
    },
  },
  mounted() {
    this.SetLanguageList()
    //this.SetLanguageAsLocale()
  },
  watch:{
    '$route.params': {
      handler() {
        this.SetLanguageAsLocale()
        if (this.$route.params.hasOwnProperty('lang')) {
          // 当前路由包含 'lang' 参数
        } else {
          // 当前路由不包含 'lang' 参数
        }
      },
      immediate: true, // 在组件挂载时立即执行一次
    },
  },
}
</script>