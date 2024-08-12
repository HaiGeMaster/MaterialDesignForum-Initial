<template>
  <Defaults />
</template>
<script>
import Vue from 'vue'
import Defaults from '@/layouts/default.vue'
import VConsole from 'vconsole';
import { scrollToTop } from '@/utils/scroll'
export default{
  name:'app',
  components:{
    Defaults,
  },
  methods:{
    IntelligentJudgmentTimestamp(timestamp) {
      const currentDate = new Date();
      const inputDate = new Date(timestamp);
      if (
        inputDate.getDate() === currentDate.getDate() &&
        inputDate.getMonth() === currentDate.getMonth() &&
        inputDate.getFullYear() === currentDate.getFullYear()
      ) {
        return inputDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      }
      const yesterday = new Date(currentDate);
      yesterday.setDate(currentDate.getDate() - 1);
      if (
        inputDate.getDate() === yesterday.getDate() &&
        inputDate.getMonth() === yesterday.getMonth() &&
        inputDate.getFullYear() === yesterday.getFullYear()
      ) {
        return this.$t('Message.App.Yesterday');
      }
      if (inputDate.getFullYear() === currentDate.getFullYear()) {
        return `${inputDate.getMonth() + 1}-${inputDate.getDate()}`;
      }
      return `${inputDate.getFullYear()}-${inputDate.getMonth() + 1}-${inputDate.getDate()}`;
    },
    TimeStampToDateTime(timestamp) {
      const date = new Date(timestamp);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const seconds = String(date.getSeconds()).padStart(2, '0');
      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    },
    UrlHeaderLang(){
      //如果this.$route.params.lang存在，就返回this.$route.params.lang，否则返回空字符串
      return this.$route.params.lang ? `/${this.$route.params.lang}` : ''
    },
    handleScroll() {
      const windowHeight = window.innerHeight;
      const scrollHeight = document.documentElement.scrollHeight;
      const scrollTop = window.scrollY || document.documentElement.scrollTop || document.body.scrollTop;
      const scrollPercentage = (scrollTop / (scrollHeight - windowHeight)) * 100;
      var cache = parseInt(scrollPercentage)
      if(cache>this.$store.getters.App.AddFab.ScrollPercentage){
        this.$store.getters.App.AddFab.ScrollMode='down'
      }else if(cache<this.$store.getters.App.AddFab.ScrollPercentage){
        this.$store.getters.App.AddFab.ScrollMode='up'
      }
      
      // if(cache>=101){
      //   scrollToTop(1000)
      // }
      this.$store.getters.App.AddFab.ScrollPercentage = cache//+1
    },
    ShowScrollTop() {
      if (window.scrollY > 1) {
        this.$store.getters.App.AddFab.ShowScrollTopBtn = true
      } else {
        this.$store.getters.App.AddFab.ShowScrollTopBtn = false
      }
      this.handleScroll()
      if (Math.ceil(window.scrollY + window.innerHeight) >= document.documentElement.scrollHeight) {
        if (this.$store.getters.App.OnScrollBottomArrayObjectCallback != null) {
          this.$G_RunOnScrollBottomCallback()
        } else {
        }
      }
    },
    RunOnScrollBottomCallback() {
      var currentPath = this.$route.path
      var currentHash = this.$route.hash
      var ArrayObjectCallback = this.$store.getters.App.OnScrollBottomArrayObjectCallback
      var cache = this.$store.getters.App.OnScrollBottomArrayObjectCallback_Cache
      ArrayObjectCallback.forEach((item, index) => {
        if ((item.path == currentPath||currentPath.indexOf(item.path)!= -1) && item.hash == currentHash) {
          if (!cache) {
            this.$store.getters.App.OnScrollBottomArrayObjectCallback_Cache = true
            item.callback()
            setTimeout(() => {
              this.$store.getters.App.OnScrollBottomArrayObjectCallback_Cache = false
            }, 750);
          } else {
            return false
          }
        }
      })
    },
    /**
     * 添加到底部回调函数 仅适用于当前路由
     * @param {*} path 路由路径
     * @param {*} hash 路由哈希
     * @param {*} callback 回调函数
     */
    AddOnScrollBottomCallback(path, hash, callback) {
      this.$store.getters.App.OnScrollBottomArrayObjectCallback.push({
        path: path,
        hash: hash,
        callback: callback
      })
    },
    CrossDomain(){//跨域
      return this.$axios.defaults.baseURL==undefined?'':this.$axios.defaults.baseURL
    },
    AvatarHandle(url,size=0){
      if(!this.IsVaild(url)){
        return `${this.CrossDomain()}${require('@/assets/images/test.webp')}`
      }
      // return `${this.CrossDomain()}${url.replace('{size}',size)}`
      return `${this.CrossDomain()}/images/get/${url}/${size}`
    },
    CoverHandle(url,size=0){
      if(!this.IsVaild(url)){
        return `${this.CrossDomain()}${require('@/assets/images/test.webp')}`
      }
      // return `${this.CrossDomain()}${url.replace('{size}',size)}`
      return `${this.CrossDomain()}/images/get/${url}/${size}`
    },
    ImgHandle(url){
      return `${this.CrossDomain()}${url}`
    },
    IsVaild(value){
      return value!=undefined&&value!=null&&value!=''
    },
    // OpenCropper(autoCropWidth,autoCropHeight,fixedBox,limitMinSize){
    //   this.$store.getters.App.Cropper.Show=true
    // },
    InitEvent() {
      //var app = document.querySelector('#app')
      window.addEventListener('scroll', () => {
        this.ShowScrollTop()
      });
      Vue.prototype.$G_IntelligentJudgmentTimestamp = this.IntelligentJudgmentTimestamp
      Vue.prototype.$G_TimeStampToDateTime = this.TimeStampToDateTime
      Vue.prototype.$G_UrlHeaderLang = this.UrlHeaderLang//语言路径函数
      Vue.prototype.$G_RunOnScrollBottomCallback = this.RunOnScrollBottomCallback
      Vue.prototype.$G_AddOnScrollBottomCallback = this.AddOnScrollBottomCallback
      Vue.prototype.$G_CrossDomain = this.CrossDomain
      Vue.prototype.$G_AvatarHandle = this.AvatarHandle
      Vue.prototype.$G_CoverHandle = this.CoverHandle
      Vue.prototype.$G_ImgHandle = this.ImgHandle
      Vue.prototype.$G_IsVaild = this.IsVaild
      //Vue.prototype.$G_t = this.tt
    },
    // tt(val){
    //   return val.indexOf('Message.') != -1 ? this.$t(val) : val
    // }
  },
  created(){
    this.InitEvent()
  },
  mounted(){
    //new VConsole();
  }
}
</script>
<style>
</style>
