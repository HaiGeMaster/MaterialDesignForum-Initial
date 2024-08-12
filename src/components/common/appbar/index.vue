<template>
  <!-- :elevate-on-scroll="$store.getters.App.ThemeButton.ElevateOnScroll" -->
  <v-app-bar app
  id="common-v-app-bar"
  class="glass-container"
  :elevate-on-scroll="$store.getters.App.ThemeButton.ElevateOnScroll"
  :clipped-left="$store.getters.App.UserSelectDeviceType=='pad'||$store.getters.App.UserSelectDeviceType=='pc'"
  elevation="2"
  :style="$store.getters.App.UserSelectDeviceType=='pad'&&$store.getters.App.Drawer.Show?'margin-left:86px;':''"
  >
    <v-tooltip bottom >
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on"
          v-show="($store.getters.App.UserSelectDeviceType=='pad'&&!$store.getters.App.Drawer.Show)||$store.getters.App.UserSelectDeviceType!='pad'"
          @click.stop="$store.getters.App.Drawer.Show = !$store.getters.App.Drawer.Show">
          <v-icon>
            {{
              ($store.getters.App.UserSelectDeviceType == 'pad' && !$store.getters.App.Drawer.Show)
              ?
              'mdi-page-last'
              :
              (
                ($store.getters.App.UserSelectDeviceType == 'mobile')
                ?
                'mdi-format-list-bulleted'
                :
                'mdi-menu'
              )
            }}
          </v-icon>
        </v-btn>
      </template>
      <span>
        {{
          $t(getBarDrawerText)
        }}
      </span>
    </v-tooltip>
    <!-- <v-btn :icon="$vuetify.breakpoint.name == 'xs'" :text="$vuetify.breakpoint.name != 'xs'" to="/">
      <v-img v-if="$vuetify.breakpoint.name == 'xs'" key="WebIcon" :src="require('@/assets/images/test.webp')" max-height="24px" max-width="24px"/>
      <v-img v-if="$vuetify.breakpoint.name != 'xs'" key="WebIconW" :src="require('@/assets/images/test.webp')" max-height="47px" max-width="128px"></v-img>
    </v-btn> -->

    <!-- <v-toolbar-title
    v-show="$store.getters.App.UserSelectDeviceType!='mobile'&&$vuetify.breakpoint.name != 'xs'"
    translate="no"
    link="/"
    :style="{
      'margin':$store.getters.App.UserSelectDeviceType=='pad'
      ?
        '0 4px'
      :
        $store.getters.App.UserSelectDeviceType=='mobile'
        ?
          '0 10px'
        :
          '0 20px'
      ,
    }">
      {{
        ($store.getters.App.UserSelectDeviceType=='mobile'||$vuetify.breakpoint.name == 'xs')?(
          ($store.getters.App.Appbar.Subheader.indexOf('Message') != -1) ?
          $t($store.getters.App.Appbar.Subheader)
          :
          $store.getters.App.Appbar.Subheader
        ):''
        
      }}
      
    </v-toolbar-title>
    <v-subheader>
      {{
        ($store.getters.App.Appbar.Subheader.indexOf('Message') != -1) ?
        $t($store.getters.App.Appbar.Subheader)
        :
        $store.getters.App.Appbar.Subheader
      }}
    </v-subheader> -->

    <v-toolbar-title
    translate="no"
    link="/"
    :style="{
      'margin':$store.getters.App.UserSelectDeviceType=='pad'
      ?
        '0 4px'
      :
        $store.getters.App.UserSelectDeviceType=='mobile'
        ?
          '0 10px'
        :
          '0 20px'
      ,
    }">
      {{
        ($store.getters.App.UserSelectDeviceType=='mobile'||$vuetify.breakpoint.name == 'xs')?(
          $t($store.getters.App.Appbar.Subheader)
        ):(
          ($store.getters.App.WebTitle.indexOf('Message') != -1) ?
          $t($store.getters.App.WebTitle)
          :
          $store.getters.App.WebTitle
        )
      }}
    </v-toolbar-title>
    <v-subheader v-show="$store.getters.App.UserSelectDeviceType!='mobile'&&$vuetify.breakpoint.name != 'xs'">
      {{
        $t($store.getters.App.Appbar.Subheader)
      }}
    </v-subheader>

    <v-spacer></v-spacer>
    <v-text-field
    :label="$t('Message.Components.Common.Appbar.Search.Search')" single-line hide-details solo
      append-icon="mdi-magnify" dense flat outlined rounded style="max-width: 300px;margin-right: 15px;"
      v-show="$vuetify.breakpoint.name == 'md' || $vuetify.breakpoint.name == 'lg' || $vuetify.breakpoint.name == 'xl'"
       v-model="SearchText" @keydown="OnStartSearchCallback">
    </v-text-field>
    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on"
        v-show="$vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm'"
        @click="$emit('OnOpenSearchCallback', true)">
          <v-icon>
            mdi-magnify
          </v-icon>
        </v-btn>
      </template>
      <span>{{ $t('Message.Components.Common.Appbar.Search.SearchTooltop') }}</span>
    </v-tooltip>
    <v-divider vertical inset style="max-height: 24px;height: 24px;margin: auto 8px;" v-show="$vuetify.breakpoint.name != 'xs'&&$vuetify.breakpoint.name != 'sm'"></v-divider>
    <NoticeButton :show="$store.getters.App.IsLogin"/>

    <!-- <v-btn icon @click="$store.getters.App.Dialog.Setting = !$store.getters.App.Dialog.Setting">
      <v-icon>mdi-cog</v-icon>
    </v-btn> -->

    <ThemeButton
    :show="($store.getters.App.IsLogin&&
    ($vuetify.breakpoint.name == 'md' || $vuetify.breakpoint.name == 'lg' || $vuetify.breakpoint.name == 'xl')
    )||!$store.getters.App.IsLogin"
    />
    
    <LanguageButton :show="($store.getters.App.IsLogin&&
    ($vuetify.breakpoint.name == 'md' || $vuetify.breakpoint.name == 'lg' || $vuetify.breakpoint.name == 'xl')
    )||!$store.getters.App.IsLogin"/>

    <DeviceTypeButton :show="($store.getters.App.IsLogin&&
    ($vuetify.breakpoint.name == 'md' || $vuetify.breakpoint.name == 'lg' || $vuetify.breakpoint.name == 'xl')
    )||!$store.getters.App.IsLogin"/>
    <v-divider vertical inset style="max-height: 24px;height: 24px;margin-top: auto;margin-bottom: auto;margin-left: 8px;margin-right: 20px;" v-show="$store.getters.App.IsLogin"></v-divider>
    <Avatar v-if="$store.getters.App.IsLogin"
    />
    <v-btn outlined class="d-none d-sm-flex d-sm-none d-md-flex" color="primary" v-if="!$store.getters.App.IsLogin"
      @click="OnOpenLoginDialogCallback(true)">
      {{ $t('Message.Components.Common.Appbar.Login') }}
    </v-btn>
    <v-btn text class="d-none d-sm-flex d-sm-none d-md-flex" v-if="!$store.getters.App.IsLogin"
      @click="OnOpenRegisterDialogCallback(true)">
      {{ $t('Message.Components.Common.Appbar.Register') }}
    </v-btn>

    <v-tooltip bottom :disabled="MoreMenu" v-if="!$store.getters.App.IsLogin">
      <template v-slot:activator="{ on: on1, attrs: attrs1 }">
        <v-menu offset-y v-model="MoreMenu" :rounded="$store.getters.App.Style.rounded">
          <template v-slot:activator="{ on: on2, attrs: attrs2 }">
            <v-btn icon v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)"
              class="d-flex d-sm-none">
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item-group>
              <v-list-item v-if="!$store.getters.App.IsLogin" @click="OnOpenLoginDialogCallback(true)">
                <v-list-item-title>{{ $t('Message.Components.Common.Appbar.Login') }}</v-list-item-title>
              </v-list-item>
              <v-list-item v-if="!$store.getters.App.IsLogin" @click="OnOpenRegisterDialogCallback(true)">
                <v-list-item-title>{{ $t('Message.Components.Common.Appbar.Register') }}</v-list-item-title>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-menu>
      </template>
      <span>{{ $t('Message.Components.Common.Appbar.More') }}</span>
    </v-tooltip>
    
    <template v-if="$store.getters.App.Appbar.TabbarsShow" v-slot:extension >
      <Tabbar :item="$store.getters.App.Appbar.TabbarsCurrentData" :path="$route.path" />
      <v-progress-linear
        style="margin-bottom: -4px;"
        :active="IsLoading"
        :indeterminate="IsLoading"
        absolute
        bottom
      ></v-progress-linear>
    </template>
    <v-progress-linear
      v-show="!$store.getters.App.Appbar.TabbarsShow"
      :active="IsLoading"
      :indeterminate="IsLoading"
      absolute
      bottom
    ></v-progress-linear>
  </v-app-bar>
</template>
<script>

import Avatar from './components/avatar/index.vue'
import Tabbar from './components/tabbar/index.vue'
import ThemeButton from './components/theme-button/index.vue'
import LanguageButton from './components/language-button/index.vue'
import NoticeButton from './components/notice-button/index.vue'
import DeviceTypeButton from './components/device-type-button/index.vue'

export default {
  components: {
    Avatar,
    Tabbar,
    ThemeButton,
    LanguageButton,
    NoticeButton,
    DeviceTypeButton,
    
  },
  name: 'appbar',
  props:{
    title: String,
  },
  data() {
    return {
      SearchText: '',
      MoreMenu: false,
      IsLoading: false,
      // WebIcon:'',
      // WebIconW:'',
    }
  },
  methods: {
    // GetWebIcon(){
    //   //获取网站图标
    //   var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
    //   if(link!=null){
    //     //this.WebIcon = link.href
    //     this.WebIcon = require('@/assets/images/test.webp')
    //     this.WebIconW = require('@/assets/images/test.webp')
    //   }
    // },
    OnStartSearchCallback(val) {
      if (val.keyCode === 13) {
        this.$emit('OnStartSearchCallback', this.SearchText)
      }
    },
    OnOpenLoginDialogCallback(val) {
      // this.$store.getters.App.IsLogin=true;
      // this.$emit('OnOpenLoginOrRegisterDialogCallback', 'login', val)
      this.$store.getters.App.Dialog.Login = val
    },
    OnOpenRegisterDialogCallback(val) {
      //this.$emit('OnOpenLoginOrRegisterDialogCallback', 'register', val)
      this.$store.getters.App.Dialog.Register = val
    },
    OnLogoutCallback(val) {
      this.$emit('OnLogoutCallback', val)
    },
    UpdateTabbarsShow(to) {
      var a = false
      switch (to.path) {
        case `${this.$G_UrlHeaderLang()}/`:
          a = false
          break
        case `${this.$G_UrlHeaderLang()}/topics`:
          if (this.$store.getters.App.IsLogin) {
            this.$store.getters.App.Appbar.TabbarsCurrentData = this.$store.getters.App.Appbar.Tabbars.topics_items
            a = true
          } else {
            a = false
          }
          break
        case `${this.$G_UrlHeaderLang()}/questions`:
          this.$store.getters.App.Appbar.TabbarsCurrentData = this.$store.getters.App.Appbar.Tabbars.questions_items
          a = true
          break
        case `${this.$G_UrlHeaderLang()}/articles`:
          this.$store.getters.App.Appbar.TabbarsCurrentData = this.$store.getters.App.Appbar.Tabbars.articles_items
          a = true
          break
        case `${this.$G_UrlHeaderLang()}/users`:
          if (this.$store.getters.App.IsLogin) {
            this.$store.getters.App.Appbar.TabbarsCurrentData = this.$store.getters.App.Appbar.Tabbars.users_items
            a = true
          } else {
            a = false
          }
          break
        case `${this.$G_UrlHeaderLang()}/notifications`:
          if (this.$store.getters.App.IsLogin) {
            this.$store.getters.App.Appbar.TabbarsCurrentData = this.$store.getters.App.Appbar.Tabbars.notifications_items
            a = true
          } else {
            a = false
          }
          break
      }
      this.$store.getters.App.Appbar.TabbarsShow = a
      // if(a==false){
      //   //获取类为v-toolbar__extension的父元素
      //   var vToolbarExtension = document.getElementsByClassName('v-toolbar__extension').parentElement
      //   //从vToolbarExtension中移除类为toolbar__extension的元素
      //   var toolbarExtension = document.getElementsByClassName('toolbar__extension')
      //   for (var i = 0; i < toolbarExtension.length; i++) {
      //     vToolbarExtension.removeChild(toolbarExtension[i])
      //   }
      // }
    }
  },
  mounted() {
    this.UpdateTabbarsShow(this.$route)
  },
  created(){
    this.$router.beforeEach((to, from, next) => {
      this.IsLoading = true
      next()
    });
    this.$router.afterEach((to, from) => {
      this.IsLoading = false
    });
  },
  watch: {
    title(val) {
      this.SetTitle(val)
    },
    '$route': function (to, from) {
      //this.GetWebIcon()
      this.UpdateTabbarsShow(to)
    },
    //监听this.$store.getters.App.IsLogin
    '$store.getters.App.IsLogin':function(val){
      this.UpdateTabbarsShow(this.$route)
    }
  },
  computed: {
    getBarDrawerText() {
      if(this.$store.getters.App.UserSelectDeviceType == 'pc'&& this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.CollapseTheSideNavigationDrawer'
      }else if(this.$store.getters.App.UserSelectDeviceType == 'pc'&& !this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.ShowSideNavigationDrawer'
      }else if(this.$store.getters.App.UserSelectDeviceType == 'pad'&& this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.CollapseTheSideNavigationBar'
      }else if(this.$store.getters.App.UserSelectDeviceType == 'pad'&& !this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.ShowSideNavigationBar'
      }else if(this.$store.getters.App.UserSelectDeviceType == 'mobile'&& this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.CollapseBottomNavigationList'
      }else if(this.$store.getters.App.UserSelectDeviceType == 'mobile'&& !this.$store.getters.App.Drawer.Show){
        return 'Message.Components.Common.Appbar.ShowBottomNavigationList'
      }
    }
  },
}
</script>
<style lang="less">
#common-v-app-bar{
  .v-text-field--solo > .v-input__control > .v-input__slot {
    background-color:inherit !important;
  }
}
</style>