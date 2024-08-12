<template>
  <!-- :hide-overlay="$store.getters.App.UserSelectDeviceType == 'pad' || $store.getters.App.UserSelectDeviceType == 'pc'" -->
  <v-navigation-drawer id="common-v-navigation-drawer" disable-route-watcher :disable-resize-watcher="false" :class="[
    'glass-container',
    'v-navigation-drawer--fixed',
    {
      //`elevation-${$store.getters.App.UserSelectDeviceType == 'pad'&&$store.getters.App.AddFab.ShowScrollTopBtn?'1':'0'}`,
      'elevation-0': $store.getters.App.UserSelectDeviceType == 'pad' && !$store.getters.App.AddFab.ShowScrollTopBtn && $store.getters.App.ThemeButton.ElevateOnScroll,
      'elevation-2': $store.getters.App.UserSelectDeviceType == 'pad' && ($store.getters.App.AddFab.ShowScrollTopBtn || !$store.getters.App.ThemeButton.ElevateOnScroll),
      'v-list-centered': $store.getters.App.UserSelectDeviceType == 'pad',
      // 'glass-container':$store.getters.App.UserSelectDeviceType == 'mobile',
    }
  ]" :style="{
  'width': $store.getters.App.UserSelectDeviceType == 'pad' ? '86px' : '',
  // 'border-radius-top-left': $store.getters.App.UserSelectDeviceType == 'pad' || $store.getters.App.UserSelectDeviceType == 'mobile'? '50px !important' : '',
  // 'border-radius-bottom-left': $store.getters.App.UserSelectDeviceType == 'pad' ? '50px !important' : '',
  // 'border-radius-top-right': $store.getters.App.UserSelectDeviceType == 'mobile' ? '50px !important' : '',
}"  v-model="$store.getters.App.Drawer.Show" app absolute floating
    :hide-overlay="$store.getters.App.UserSelectDeviceType == 'pad' || $vuetify.breakpoint.name != 'xs'"
    :permanent="$store.getters.App.UserSelectDeviceType == 'pad' && $store.getters.App.Drawer.Show"
    :touchless="$store.getters.App.UserSelectDeviceType == 'pad'"
    :mini-variant="$store.getters.App.UserSelectDeviceType == 'pad'"
    :temporary="$vuetify.breakpoint.name != 'lg' && $vuetify.breakpoint.name != 'xl'"
    :clipped="$store.getters.App.UserSelectDeviceType != 'pad'"
    :bottom="$store.getters.App.UserSelectDeviceType == 'mobile'">
    <template v-slot:prepend>
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn :block="$store.getters.App.UserSelectDeviceType == 'mobile'"
            :icon="$store.getters.App.UserSelectDeviceType == 'pad'"
            :text="$store.getters.App.UserSelectDeviceType == 'mobile'"
            v-show="$store.getters.App.UserSelectDeviceType != 'pc'" v-bind="attrs" v-on="on" :style="{
              'width': '86px',
              'height': $store.getters.App.UserSelectDeviceType == 'mobile' ? '56px' : '86px',
              'margin-top': $vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm' ? '0' : '4px',
            }" @click.stop="$store.getters.App.Drawer.Show = !$store.getters.App.Drawer.Show">
            <v-icon>
              {{
                (
                  $store.getters.App.UserSelectDeviceType == 'pad' && $store.getters.App.Drawer.Show
                    ?
                    'mdi-menu-open'
                    :
                    (
                      $store.getters.App.UserSelectDeviceType == 'pad' && !$store.getters.App.Drawer.Show
                        ?
                        'mdi-page-last'
                        :
                        (
                          $store.getters.App.UserSelectDeviceType == 'mobile' && $store.getters.App.Drawer.Show
                            ?
                            'mdi-chevron-down'
                            :
                            'mdi-page-last'
                        )
                    )
                )
              }}
            </v-icon>
          </v-btn>
        </template>
        <span>{{ $t(getBarDrawerText) }}</span>
      </v-tooltip>
    </template>
    <v-list nav rounded>
      <!-- :shaped="
      $store.getters.App.UserSelectDeviceType != 'pad' &&
      $store.getters.App.UserSelectDeviceType != 'mobile'
    " -->
      <v-list-item-group color="primary" v-model="selectedItem" class="layout-colourless">
        <v-tooltip right v-for="(item, i) in item_1" :disabled="$store.getters.App.UserSelectDeviceType != 'pad'"
          :key="item.routers">
          <template v-slot:activator="{ on, attrs }">
            <v-list-item v-bind="attrs" v-on="on" exact-path :key="item.routers"
              v-ripple :to="`${$G_UrlHeaderLang()}${item.routers}`" @click="SetItemActive(item.text)">
              <v-list-item-icon :style="{
                'flex-direction': $store.getters.App.UserSelectDeviceType == 'pad' ? 'column' : '',
              }">
                <v-icon>{{ item.icon }}</v-icon>
                <span v-if="$store.getters.App.UserSelectDeviceType == 'pad'" style="margin-top:8px;" class="icon-span">{{
                  $t(item.text) }}</span>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t(item.text) }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <span>{{ $t(item.text) }}</span>
        </v-tooltip>

        <v-divider style="margin-bottom: 8px;"></v-divider>

        <v-tooltip right v-for="(item, i) in item_2" :disabled="$store.getters.App.UserSelectDeviceType != 'pad'"
          :key="item.routers"
          v-if="item.needLogin == false || (item.needLogin == $store.getters.App.IsLogin)">
          <template v-slot:activator="{ on, attrs }">
            <v-list-item v-bind="attrs" v-on="on" exact-path :key="item.routers"
              :id="'items_2_' + i" v-ripple :to="item.routers.indexOf('local_user_id') != -1
                  ? $G_UrlHeaderLang() + item.routers.replace('local_user_id', $store.getters.App.User.user_id)
                  : $G_UrlHeaderLang() + item.routers
                "
              @click="SetItemActive((item.text.indexOf('PersonalData') != -1) ? $store.getters.App.User.username : item.text)">
              <v-list-item-icon :style="{
                'flex-direction': $store.getters.App.UserSelectDeviceType == 'pad' ? 'column' : '',
              }">
                <v-icon>{{ item.icon }}</v-icon>
                <span v-if="$store.getters.App.UserSelectDeviceType == 'pad'" style="margin-top:8px;" class="icon-span">{{
                  $t(item.text) }}</span>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t(item.text) }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <span>{{ $t(item.text) }}</span>
        </v-tooltip>

        <v-divider style="margin-bottom: 8px;" v-if="item_3 != null"></v-divider>

        <v-tooltip right v-for="(item, i) in item_3" :disabled="$store.getters.App.UserSelectDeviceType != 'pad'"
          :key="item.routers"
          v-if="item.needLogin == false || (item.needLogin == $store.getters.App.IsLogin)">
          <template v-slot:activator="{ on, attrs }">
            <v-list-item v-bind="attrs" v-on="on" exact-path :key="item.routers"
              v-ripple :to="item.routers.indexOf('local_user_id') != -1
                  ? $G_UrlHeaderLang() + item.routers.replace('local_user_id', $store.getters.App.User.user_id)
                  : $G_UrlHeaderLang() + item.routers
                "
              @click="SetItemActive((item.text.indexOf('PersonalData') != -1) ? $store.getters.App.User.username : item.text)">
              <v-list-item-icon :style="{
                'flex-direction': $store.getters.App.UserSelectDeviceType == 'pad' ? 'column' : '',
              }">
                <v-icon>{{ item.icon }}</v-icon>
                <span v-if="$store.getters.App.UserSelectDeviceType == 'pad'" style="margin-top:8px;" class="icon-span">{{
                  $t(item.text) }}</span>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t(item.text) }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <span>{{ $t(item.text) }}</span>
        </v-tooltip>

        <!-- <v-tooltip right v-if="item_3!=null" v-for="(item, i) in item_3"
          :disabled="$store.getters.App.UserSelectDeviceType != 'pad'">
          <template v-slot:activator="{ on, attrs }">
            <v-list-item v-bind="attrs" v-on="on" exact-path :key="'items_3_' + i" :id="'items_3_' + i" v-ripple
              :to="
                item.routers.indexOf('local_user_id') != -1 
                ? $G_UrlHeaderLang() + item.routers.replace('local_user_id', $store.getters.App.User.user_id) 
                : $G_UrlHeaderLang() + item.routers
              "
              @click="SetItemActive((item.text.indexOf('PersonalData') != -1) ? $store.getters.App.User.username : item.text)"
              v-if="(item.needLogin == $store.getters.App.IsLogin) || !item.needLogin">
              <v-list-item-icon :style="{
                'flex-direction': $store.getters.App.UserSelectDeviceType == 'pad'?'column':'',
              }">
                <v-icon>{{ item.icon }}</v-icon>
                <span v-if="$store.getters.App.UserSelectDeviceType == 'pad'" style="margin-top:8px;" class="icon-span">{{ $t(item.text) }}</span>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t(item.text) }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <span>{{ $t(item.text) }}</span>
        </v-tooltip> -->
      </v-list-item-group>
    </v-list>
    <template v-slot:append>
      <AppendFooter />
    </template>
  </v-navigation-drawer>
</template>
<script>
import AppendFooter from './components/append-footer/index.vue'
export default {
  name: 'drawer',
  props: {
    //data: Object,
    // custom_data: {
    //   type: Object,
    //   default: null,
    // },
    show: {
      type: Boolean,
      default: false,
    },
    item_1: null,
    item_2: null,
    item_3: null,
  },
  components: {
    AppendFooter,
  },
  data: () => ({
    selectedItem: null,
  }),
  methods: {
    isActive(path) {
      return this.$route.path === path;
    },
    TesterIsPhone() {
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
        case 'sm':
        case 'md':
          this.$store.getters.App.Drawer.Show = false
          return true
        case 'lg':
        case 'xl':
          this.$store.getters.App.Drawer.Show = true
          return false
      }
    },
    SetItemActive(val = '') {
      var element1 = document.getElementById('items_2_1')
      if (val.indexOf('Message.') == -1) {
        element1.classList.remove('v-item--active')
        element1.classList.remove('v-list-item--active')
      } else if (val.indexOf('Users') != -1) {
        element1.classList.add('v-item--active')
        element1.classList.add('v-list-item--active')
      }
    }
  },
  watch: {
  },
  computed: {
    height() {
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
        case 'sm':
        case 'md':
          return false
        case 'lg':
        case 'xl':
          return true
      }
    },
    getBarDrawerText() {
      if (this.$store.getters.App.UserSelectDeviceType == 'pc' && this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.CollapseTheSideNavigationDrawer'
      } else if (this.$store.getters.App.UserSelectDeviceType == 'pc' && !this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.ShowSideNavigationDrawer'
      } else if (this.$store.getters.App.UserSelectDeviceType == 'pad' && this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.CollapseTheSideNavigationBar'
      } else if (this.$store.getters.App.UserSelectDeviceType == 'pad' && !this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.ShowSideNavigationBar'
      } else if (this.$store.getters.App.UserSelectDeviceType == 'mobile' && this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.CollapseBottomNavigationList'
      } else if (this.$store.getters.App.UserSelectDeviceType == 'mobile' && !this.$store.getters.App.Drawer.Show) {
        return 'Message.Components.Common.Drawer.ShowBottomNavigationList'
      }
    }
  },
  created() {
    this.TesterIsPhone()
  },
}
</script>
<style lang="less">
.v-navigation-drawer__content {
  .v-list-centered & {
    display: flex;
    align-items: center;
    padding: 0;
  }

  .v-list {
    .v-list-item {
      .v-list-centered & {
        justify-content: center;

        //height: 86px;
      }

      .icon-span {
        font-size: 12px;
        text-align: center;
        // display:none;
        // .v-item--active & {
        //   display: block;
        // }
      }

      .v-list-item__icon {
        .v-navigation-drawer--bottom & {
          //控制手机端图标间距 nav rounded时使用
          margin-right: 32px;
          margin-left: 10px;
        }
        .v-navigation-drawer--clipped & {//控制pc端图标间距 nav rounded时使用
          //margin-right: 32px;
          margin-left: 10px;
        }
      }
    }

    .v-list-item:before {
      .v-list-centered & {
        //border-radius: 0;
        border-radius: 50px !important; //控制pad时按钮的圆角
      }
    }

    .v-list-centered & {
      padding: 0;
      width: 86px;

      @media (max-height: 800px) {
        height: inherit;
      }

      //height: 86px;
    }

    .v-item-group {
      .v-list-centered & {
        @media (max-height: 800px) {
          height: inherit;
        }
      }
    }
  }
}

.v-navigation-drawer--fixed {
  position: fixed !important;
}
</style>