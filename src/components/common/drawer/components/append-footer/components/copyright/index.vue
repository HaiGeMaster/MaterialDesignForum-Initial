<template>
  <div class="copyright-components">
    <!-- <p>
      <a :href="`${$G_UrlHeaderLang()}/`">
        <img :src="require('@/assets/images/test.webp')" height="20px" width="20px"/>
        Copyright © 2022 - {{ new Date().getFullYear() }}
      </a>
    </p>
    <p>
      <a href="http://beian.miit.gov.cn" target="_blank">
        <img :src="require('@/assets/images/test.webp')
          ">
        粤ICP备2023097526号
      </a>
    </p>
    <p>
      <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=0" target="_blank">
        <img :src="require('@/assets/images/test.webp')
          ">
        粤公网安备?号(申请中)
      </a>
    </p>
    <p>
      Powered by
      <a :href="`${$G_UrlHeaderLang()}/users/1`" target="_blank">
        HaiGeMaster
      </a>
    </p>
    <p>
      Technology Source From
    </p>
    <p>
      <a href="/" target="_blank">
        Material Design Forum
      </a>
      
    </p>
    <p>
      <a href="https://v2.vuetifyjs.com" target="_blank">
        Vuetify
      </a>
      &
      <a href="https://vuejs.org" target="_blank">
        Vue
      </a>
      &
      <a href="https://vuex.vuejs.org" target="_blank">
        VueX
      </a>
    </p>
    <p>
      <a href="https://router.vuejs.org" target="_blank">
        VueRouter
      </a>
      &
      <a href="https://vue-i18n.intlify.dev" target="_blank">
        VueI18n
      </a>
    </p> -->

    <p>
      <a :href="`${$G_UrlHeaderLang()}/`">
        <img :src="require('@/assets/images/test.webp')" height="20px" width="20px"/>
        Copyright © 2022 - {{ new Date().getFullYear() }}
      </a>
    </p>
    <p>
      <a href="http://beian.miit.gov.cn" target="_blank">
        <img :src="require('@/assets/images/test.webp')
          ">
        粤ICP备2023097526号
      </a>
    </p>
    <p>
      <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=0" target="_blank">
        <img :src="require('@/assets/images/test.webp')
          ">
        粤公网安备?号(申请中)
      </a>
    </p>

    <p>
      Powered by
    </p>
    <p>
      <a href="https://v2.vuetifyjs.com/" target="_blank">
        Vuetify
      </a>
      &
      <a href="/" target="_blank">
        Material Design Forum
      </a>
    </p>
  </div>
</template>
<script>
export default {
  name: "drawer-append-footer-copyright",
  methods: {
    openLink(link) {
      window.open(link, '_blank')
    },
    // GetWebIcon(){
    //   //获取网站图标
    //   var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
    //   if(link!=null){
    //     return link.href
    //   }
    // }
  }
}
</script>