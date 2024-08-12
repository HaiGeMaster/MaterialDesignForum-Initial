<template>
  <!-- <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-btn v-show="show" icon v-bind="attrs" v-on="on" @click="SetVuetifyTheme()">
        <v-icon>
          mdi-brightness-{{ $vuetify.theme.dark ? '6' : '4' }}
        </v-icon>
      </v-btn>
    </template>
    <span>{{ $vuetify.theme.dark ? $t('Message.Components.Common.Appbar.ThemeButton.LightTheme') :
      $t('Message.Components.Common.Appbar.ThemeButton.DarkTheme') }}</span>
  </v-tooltip> -->
  <v-tooltip bottom>
    <template v-slot:activator="{ on: on1, attrs: attrs1 }">
      <v-menu :close-on-content-click="false" :nudge-width="230" offset-y :rounded="$store.getters.App.Style.rounded">
        <template v-slot:activator="{ on: on2, attrs: attrs2 }">
          <v-btn v-show="show" icon v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)">
            <v-icon>
              mdi-brightness-{{ $vuetify.theme.dark ? '6' : '4' }}
            </v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-tabs v-model="tab" grow>
            <v-tabs-slider color="primary"></v-tabs-slider>

            <v-tab v-for="item in items" :key="item.mode"
              @click="SetVuetifyTheme">
              {{ $t(item.name) }}
            </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item>
              <v-card flat class="layout-colourless">
                <v-card-text>
                  {{ $t('Message.Components.Common.Appbar.ThemeButton.Application') }}
                  <br />
                  <!-- <v-btn color="primary" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Primary') }}
                  </v-btn>
                  <v-btn color="secondary" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Secondary') }}
                  </v-btn>
                  <v-btn color="accent" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Accent') }}
                  </v-btn> -->
                  <v-btn-toggle
                    v-model="light_color_select"
                    borderless
                  >
                    <v-btn value="primary" color="primary" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Primary') }}
                    </v-btn>

                    <v-btn value="secondary" color="secondary" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Secondary') }}
                    </v-btn>

                    <v-btn value="accent" color="accent" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Accent') }}
                    </v-btn>
                  </v-btn-toggle>
                  <br v-if="light_color_select!=null"/>
                  <v-color-picker v-model="light_color" v-if="light_color_select!=null"></v-color-picker>
                  <br />
                  {{ $t('Message.Components.Common.Appbar.ThemeButton.PageBackground') }}
                  <br />
                  <v-btn-toggle v-model="page_background.light.mode" borderless>
                    <v-btn value="color">
                      <span class="hidden-sm-and-down">{{ $t('Message.Components.Common.Appbar.ThemeButton.Color') }}</span>

                      <v-icon right>
                        mdi-palette
                      </v-icon>
                    </v-btn>

                    <v-btn value="image">
                      <span class="hidden-sm-and-down">{{ $t('Message.Components.Common.Appbar.ThemeButton.Image') }}</span>

                      <v-icon right>
                        mdi-image
                      </v-icon>
                    </v-btn>
                  </v-btn-toggle>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat class="layout-colourless">
                <v-card-text>
                  {{ $t('Message.Components.Common.Appbar.ThemeButton.Application') }}
                  <br />
                  <!-- <v-btn color="primary" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Primary') }}
                  </v-btn>
                  <v-btn color="secondary" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Secondary') }}
                  </v-btn>
                  <v-btn color="accent" text>
                    {{ $t('Message.Components.Common.Appbar.ThemeButton.Accent') }}
                  </v-btn> -->
                  <v-btn-toggle
                    v-model="dark_color_select"
                    tile
                    color="deep-purple accent-3"
                    group
                  >
                    <v-btn value="primary" color="primary" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Primary') }}
                    </v-btn>

                    <v-btn value="secondary" color="secondary" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Secondary') }}
                    </v-btn>

                    <v-btn value="accent" color="accent" text>
                      {{ $t('Message.Components.Common.Appbar.ThemeButton.Accent') }}
                    </v-btn>
                  </v-btn-toggle>
                  <br v-if="dark_color_select!=null"/>
                  <v-color-picker v-model="dark_color" v-if="dark_color_select!=null"></v-color-picker>
                  <br />
                  {{ $t('Message.Components.Common.Appbar.ThemeButton.PageBackground') }}
                  <br />
                  <v-btn-toggle v-model="page_background.dark.mode" borderless>
                    <v-btn value="color">
                      <span class="hidden-sm-and-down">{{ $t('Message.Components.Common.Appbar.ThemeButton.Color') }}</span>

                      <v-icon right>
                        mdi-palette
                      </v-icon>
                    </v-btn>

                    <v-btn value="image">
                      <span class="hidden-sm-and-down">{{ $t('Message.Components.Common.Appbar.ThemeButton.Image') }}</span>

                      <v-icon right>
                        mdi-image
                      </v-icon>
                    </v-btn>
                  </v-btn-toggle>
                </v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
          <v-divider></v-divider>
          <v-card-actions :color="$vuetify.theme.dark ? 'layout-dark-color-3' : 'grey lighten-5'">
            <v-btn color="primary" text @click="SaveDefaultTheme">
              {{ $t('Message.Components.Common.Appbar.ThemeButton.SetDefault') }}
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" text outlined @click="SaveTheme">
              {{ $t('Message.Components.Common.Appbar.ThemeButton.SaveAndSet') }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </template>
    <span>{{ $vuetify.theme.dark ? $t('Message.Components.Common.Appbar.ThemeButton.LightTheme') :
      $t('Message.Components.Common.Appbar.ThemeButton.DarkTheme') }}</span>
  </v-tooltip>
</template>
<script>
import { colors } from 'vuetify/lib'
export default {
  name: 'theme-button',
  props: {
    show: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      tab: null,
      items: [
        {
          name: 'Message.Components.Common.Appbar.ThemeButton.Light',
          mode: 'light',
        },
        {
          name: 'Message.Components.Common.Appbar.ThemeButton.Dark',
          mode: 'dark',
        },
      ],
      light_color_select: 'primary',
      dark_color_select: 'primary',
      light_color: '',
      dark_color: '',
      page_background: {
        light:{
          mode: 'color',//'color','image'
        },
        dark:{
          mode: 'color',//'color','image'
        }
      },
      theme: {
        setting: {
          light: {
            primary: '',
            secondary: '',
            accent: '',
            backgroundColor: '',
            backgroundImage: '',
            page_background: {
              mode: '',//'color','image'
            }
          },
          dark: {
            primary: '',
            secondary: '',
            accent: '',
            backgroundColor: '',
            backgroundImage: '',
            page_background: {
              mode: '',//'color','image'
            }
          },
          default_light: {
            primary: colors.blue,
            secondary: colors.orange,
            accent: colors.pink,
            backgroundColor: '#ffffff',
            backgroundImage: '/src/Static/WallPaper/material-design-4k.jpg',
            page_background: {
              mode: 'color',//'color','image'
            }
          },
          default_dark:{
            primary: colors.blue,
            secondary: colors.orange,
            accent: colors.pink,
            backgroundColor: '#2d2d2d',
            backgroundImage: '/src/Static/WallPaper/MDF-5000.png',
            page_background: {
              mode: 'color',//'color','image'
            }
            //error: colors.red,
          }
        },
      },
    }
  },
  methods: {
    SetVuetifyTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      this.SetTheme()
      //this.SetHtmlWallpaper()
    },
    SaveTheme(){
      localStorage.setItem('theme',JSON.stringify(this.theme))
      this.SetTheme()
    },
    InitTheme() {
      
      // this.$vuetify.theme.themes.light = {
      //   primary: colors.blue,
      //   secondary: colors.orange,
      //   accent: colors.pink,
      //   error: colors.red,
      // }
      // // this.$vuetify.theme.themes.dark = {
      // //   primary: colors.blue,
      // //   secondary: colors.orange,
      // //   accent: colors.pink,
      // //   error: colors.red,
      // // }
      // this.$vuetify.theme.themes.dark = {
      //   primary: colors.orange,
      //   secondary: colors.green,
      //   accent: colors.green,
      //   error: colors.red,
      // }
      if (this.$store.getters.App.ThemeIsSet) {
        return
      } else {
        this.$store.getters.App.ThemeIsSet = true
      }
      window.matchMedia('(prefers-color-scheme: dark)').addListener((e) => {
        this.$vuetify.theme.dark = e.matches;
      });
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        this.$vuetify.theme.dark = true;
      } else {
        this.$vuetify.theme.dark = false;
      }
      this.SetTheme()
      // this.SetHtmlWallpaper()
    },
    SetTheme(){
      var local = JSON.parse(localStorage.getItem('theme'))||this.theme

      this.theme.setting.light.primary = local.setting.light.primary||this.theme.setting.default_light.primary
      this.theme.setting.light.secondary = local.setting.light.secondary||this.theme.setting.default_light.secondary
      this.theme.setting.light.accent = local.setting.light.accent||this.theme.setting.default_light.accent
      this.theme.setting.light.backgroundColor = local.setting.light.backgroundColor||this.theme.setting.default_light.backgroundColor
      this.theme.setting.light.backgroundImage = local.setting.light.backgroundImage||this.theme.setting.default_light.backgroundImage
      this.theme.setting.light.page_background.mode = local.setting.light.page_background.mode||this.theme.setting.default_light.page_background.mode

      this.theme.setting.dark.primary = local.setting.dark.primary||this.theme.setting.default_dark.primary
      this.theme.setting.dark.secondary = local.setting.dark.secondary||this.theme.setting.default_dark.secondary
      this.theme.setting.dark.accent = local.setting.dark.accent||this.theme.setting.default_dark.accent
      this.theme.setting.dark.backgroundColor = local.setting.dark.backgroundColor||this.theme.setting.default_dark.backgroundColor
      this.theme.setting.dark.backgroundImage = local.setting.dark.backgroundImage||this.theme.setting.default_dark.backgroundImage
      this.theme.setting.dark.page_background.mode = local.setting.dark.page_background.mode||this.theme.setting.default_dark.page_background.mode
      
      this.$vuetify.theme.themes.light = {
        primary: this.theme.setting.light.primary||this.theme.setting.default_light.primary,
        secondary: this.theme.setting.light.secondary||this.theme.setting.default_light.secondary,
        accent: this.theme.setting.light.accent||this.theme.setting.default_light.accent,
      }
      this.$vuetify.theme.themes.dark = {
        primary: this.theme.setting.dark.primary||this.theme.setting.default_dark.primary,
        secondary: this.theme.setting.dark.secondary||this.theme.setting.default_dark.secondary,
        accent: this.theme.setting.dark.accent||this.theme.setting.default_dark.accent,
      }

      this.page_background.light.mode = this.theme.setting.light.page_background.mode||this.theme.setting.default_light.page_background.mode
      this.page_background.dark.mode = this.theme.setting.dark.page_background.mode||this.theme.setting.default_dark.page_background.mode

      if(this.$vuetify.theme.dark){
        if(this.page_background.dark.mode == 'color'){
          this.SetHtmlWallpaper(this.page_background.dark.mode,this.theme.setting.dark.backgroundColor||this.theme.setting.default_dark.backgroundColor)
        }else if(this.page_background.dark.mode == 'image'){
          this.SetHtmlWallpaper(this.page_background.dark.mode,this.theme.setting.dark.backgroundImage||this.theme.setting.default_dark.backgroundImage)
        }
      }else{
        if(this.page_background.light.mode == 'color'){
          this.SetHtmlWallpaper(this.page_background.light.mode,this.theme.setting.light.backgroundColor||this.theme.setting.default_light.backgroundColor)
        }else if(this.page_background.light.mode == 'image'){
          this.SetHtmlWallpaper(this.page_background.light.mode,this.theme.setting.light.backgroundImage||this.theme.setting.default_light.backgroundImage)
        }
      }
    },
    SetHtmlWallpaper(mode = '',val = '') {
      //console.log(mode)
      //console.log(val)
      if(mode=='color'){
        const html = document.querySelector('html');
        html.style.backgroundImage = ''
        html.style.backgroundColor = val
      }else if(mode=='image'){
        //将html背景图片设置
        const html = document.querySelector('#client');
        //html.style.backgroundImage = `url(${require('@/assets/images/test.webp')})`
        html.style.backgroundImage = `url(${val})`
        //背景图片的缩放方式
        html.style.backgroundSize = 'cover'
        //背景图片不随页面滚动
        html.style.backgroundAttachment = 'fixed'
        //背景图片缩放时始终居中
        html.style.backgroundPosition = 'center center'
      }
    },
    SaveDefaultTheme(){
      this.theme.setting.light.primary = this.theme.setting.default_light.primary
      this.theme.setting.light.secondary = this.theme.setting.default_light.secondary
      this.theme.setting.light.accent = this.theme.setting.default_light.accent
      this.theme.setting.light.backgroundColor = this.theme.setting.default_light.backgroundColor
      this.theme.setting.light.backgroundImage = this.theme.setting.default_light.backgroundImage
      this.theme.setting.light.page_background.mode = this.theme.setting.default_light.page_background.mode

      this.theme.setting.dark.primary = this.theme.setting.default_dark.primary
      this.theme.setting.dark.secondary = this.theme.setting.default_dark.secondary
      this.theme.setting.dark.accent = this.theme.setting.default_dark.accent
      this.theme.setting.dark.backgroundColor = this.theme.setting.default_dark.backgroundColor
      this.theme.setting.dark.backgroundImage = this.theme.setting.default_dark.backgroundImage
      this.theme.setting.dark.page_background.mode = this.theme.setting.default_dark.page_background.mode

      this.$vuetify.theme.themes.light = {
        primary: this.theme.setting.default_light.primary,
        secondary: this.theme.setting.default_light.secondary,
        accent: this.theme.setting.default_light.accent,
      }

      this.$vuetify.theme.themes.dark = {
        primary: this.theme.setting.default_dark.primary,
        secondary: this.theme.setting.default_dark.secondary,
        accent: this.theme.setting.default_dark.accent,
      }

      this.page_background.light.mode = this.theme.setting.default_light.page_background.mode
      this.page_background.dark.mode = this.theme.setting.default_dark.page_background.mode

      if(this.$vuetify.theme.dark){
        if(this.page_background.dark.mode == 'color'){
          this.SetHtmlWallpaper(this.page_background.dark.mode,this.theme.setting.dark.backgroundColor)
        }else if(this.page_background.dark.mode == 'image'){
          this.SetHtmlWallpaper(this.page_background.dark.mode,this.theme.setting.dark.backgroundImage)
        }
      }else{
        if(this.page_background.light.mode == 'color'){
          this.SetHtmlWallpaper(this.page_background.light.mode,this.theme.setting.light.backgroundColor)
        }else if(this.page_background.light.mode == 'image'){
          this.SetHtmlWallpaper(this.page_background.light.mode,this.theme.setting.light.backgroundImage)
        }
      }

      localStorage.setItem('theme',JSON.stringify(this.theme))
    }
  },
  mounted() {
    this.InitTheme()
  },
  watch: {
    '$vuetify.theme.dark': function (val) {
      if (val) {
        this.tab = 1
      } else {
        this.tab = 0
      }
    },
    // page_background(val){
    //   this.theme.setting.light.page_background.mode = val.light.mode
    //   this.theme.setting.dark.page_background.mode = val.dark.mode
    // }
    //对page_background进行深入监听
    page_background: {
      handler(val) {
        this.theme.setting.light.page_background.mode = val.light.mode
        this.theme.setting.dark.page_background.mode = val.dark.mode
      },
      deep: true,
    }
    // tab (val) {
    //   //console.log(val)
    // },
  },
}
</script>