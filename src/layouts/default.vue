<template>
  <v-app>
    <Appbar v-if="!$store.getters.App.AppbarSearch.Show"
      @OnOpenSearchCallback="$store.getters.App.AppbarSearch.Show = true" />
    <AppbarSearch v-if="$store.getters.App.AppbarSearch.Show" @OnStartSearchCallback=""
      @OnCloseSearchCallback="$store.getters.App.AppbarSearch.Show = false" />
    <Drawer
      :item_1="$store.getters.App.Interface=='admin'? $store.getters.App.Drawer.admin_items_1 : $store.getters.App.Drawer.user_items_1"
      :item_2="$store.getters.App.Interface=='admin'? $store.getters.App.Drawer.admin_items_2 : $store.getters.App.Drawer.user_items_2"
      :item_3="$store.getters.App.Interface=='admin'? $store.getters.App.Drawer.admin_items_3 : null"
     />
    <!-- <Drawer
      v-if="!$store.getters.App.Interface=='admin'"
      :show="$store.getters.App.Drawer.Show"
      :item_1="$store.getters.App.Drawer.user_items_1"
      :item_2="$store.getters.App.Drawer.user_items_2"
     />
    <Drawer
      v-if="$store.getters.App.Interface=='admin'"
      :show="$store.getters.App.Drawer.Show"
      :item_1="$store.getters.App.Drawer.admin_items_1"
      :item_2="$store.getters.App.Drawer.admin_items_2"
      :item_3="$store.getters.App.Drawer.admin_items_3"
    /> -->
    <v-main
    app class=""
      :style="$store.getters.App.UserSelectDeviceType == 'pad' && $store.getters.App.Drawer.Show ? 'padding-left:86px;' : ''">
      <v-expand-transition>
        <!-- <keep-alive> -->
          <router-view/>
        <!-- </keep-alive> -->
      </v-expand-transition>
      <ToTopFabButton />
      <AddFabButton />
    </v-main>
    <NavFooter :com_item="$store.getters.App.NavFooter.user_com_item" 
    :login_item="$store.getters.App.Interface=='admin'? $store.getters.App.NavFooter.admin_login_item : $store.getters.App.NavFooter.user_login_item" />
    <LoginDialog />
    <RegisterDialog />
    <ResetDialog />
    <Snackbar />
    <!-- <MdEditor mode="auto" /> -->
    <TopicSelectorDialog />
    <!-- <UsersDialog /> -->
    <!-- <SettingDialog/> -->
  </v-app>
</template>
<script>
import messages from '@/assets/language/language.js'
import Appbar from '@/components/common/appbar/index.vue'
import AppbarSearch from '@/components/common/appbar/components/search/index.vue'
import Drawer from '@/components/common/drawer/index.vue'
import ToTopFabButton from '@/components/totop-fab-button/index.vue'
import AddFabButton from '@/components/add-fab-button/index.vue'
import NavFooter from '@/components/common/nav-footer/index.vue'
import Vue from 'vue'
import LoginDialog from '@/components/common/account/login.vue'
import RegisterDialog from '@/components/common/account/register.vue'
import ResetDialog from '@/components/common/account/reset.vue'
import TopicSelectorDialog from '@/components/md-editor/components/topic-selector-dialog/index.vue'
//import SettingDialog from '@/components/setting-dialog/index.vue'
import Snackbar from '@/components/snackbar/index.vue'
// import MdEditor from '@/components/md-editor/index.vue'
//import UsersDialog from '@/components/users-dialog/index.vue'
export default {
  name: 'layouts-default',
  components: {
    Appbar,
    AppbarSearch,
    Drawer,
    ToTopFabButton,
    AddFabButton,
    NavFooter,
    LoginDialog,
    RegisterDialog,
    ResetDialog,
    TopicSelectorDialog,
    //SettingDialog,
    Snackbar,
    // MdEditor,
    // UsersDialog,
  },
  data: () => ({
    Drawer: true,
    Search: false,
    SetWebSubTitle_Cache: '',
    DevMode: true,
  }),
  methods: {
    SetWebSubTitle(val = '', ToAppbarSubTitle = false) {
      if (val == '') {
        val = this.SetWebSubTitle_Cache
      }
      if (ToAppbarSubTitle) {
        this.$store.getters.App.Appbar.Subheader = val;
      }
      const title = this.$store.getters.App.WebTitle;
      const element = document.querySelector('head title');
      if (element) {
        var vas_cache = val
        this.SetWebSubTitle_Cache = vas_cache;
        (val.indexOf('Message.') != -1) ? element.innerText = `${this.$t(val)} - ${title}` : element.innerText = `${val} - ${title}`
      }
      return val
    },
    SetAppbarSubTitle(val = '') {
      this.$store.getters.App.Appbar.Subheader = val;
    },
    // HasLangPath() {
    //   var path = this.$route.path
    //   var path1 = path.split('/')[1]
    //   var arr = []
    //   for (let langCode in messages) {
    //     if(messages[langCode].Message.usability){
    //       arr.push(langCode)
    //     }
    //   }
    //   if(arr.indexOf(path1)!=-1){
    //     return true
    //   }else{
    //     return false
    //   }
    // },
    SAlert(val) {
      this.$store.getters.App.Snackbar.Text = val
      this.$store.getters.App.Snackbar.Show = true
    },
    InitEvent() {
      Vue.prototype.$G_SetWebSubTitle = this.SetWebSubTitle
      Vue.prototype.$G_SetAppbarSubTitle = this.SetAppbarSubTitle
      //Vue.prototype.$G_HasLangPath = this.HasLangPath
      Vue.prototype.$G_SAlert = this.SAlert
    },
  },
  created() {
    this.InitEvent()
  },
  mounted() {
    if (this.DevMode) {
    }
  },
  watch: {
    '$i18n.locale': function (val) {
      this.SetWebSubTitle()
    },
  },
};
</script>
<style lang="less">
.v-main__wrap {
  // .theme--dark.v-application &{
  //   background-color: #303030;
  // }
  background-color: #30303000;
}

.theme--light.v-application {
  background-color: #30303000;
}

.theme--dark.v-application {
  background-color: #30303000;
}

// body{
//   .theme--dark & {
//     background-color: #303030;
//   }
//   .theme--light & {
//     background-color: #303030;
//   }
// }
</style>
