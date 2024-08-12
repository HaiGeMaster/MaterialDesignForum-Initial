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
          <v-card-text>
            <v-switch v-model="$vuetify.theme.dark" :label="$vuetify.theme.dark ? $t('Message.Components.Common.Appbar.ThemeButton.DarkTheme') :
              $t('Message.Components.Common.Appbar.ThemeButton.LightTheme')"></v-switch>

            {{ $t('Message.Components.Common.Appbar.ThemeButton.Color') }}
            <br />
            <br />
            <v-btn-toggle v-model="theme_color_select" outlined>
              <v-btn value="primary" :color="locale_theme.primary || 'primary'" text>
                {{ $t('Message.Components.Common.Appbar.ThemeButton.Primary') }}
              </v-btn>

              <v-btn value="secondary" :color="locale_theme.secondary || 'secondary'" text>
                {{ $t('Message.Components.Common.Appbar.ThemeButton.Secondary') }}
              </v-btn>

              <v-btn value="accent" :color="locale_theme.accent || 'accent'" text>
                {{ $t('Message.Components.Common.Appbar.ThemeButton.Accent') }}
              </v-btn>
            </v-btn-toggle>
            <br v-if="theme_color_select != null" />
            <br v-if="theme_color_select != null" />
            <span v-if="theme_color_select != null">
              {{ select_color }}
            </span>
            <v-color-picker v-model="select_color" width="246px" v-if="theme_color_select != null"></v-color-picker>

            <br />
            <br />
            <!-- @click:append-outer="locale_theme.BackgroundImage = require('@/assets/images/test.webp').toString(); $forceUpdate();" -->
            <v-text-field v-model="locale_theme.BackgroundImage" dense
              :label="$t('Message.Components.Common.Appbar.ThemeButton.BackgroundImage')"
              placeholder="https://example.com/image.png" append-outer-icon="mdi-link-variant"
              @click:append-outer="locale_theme.BackgroundImage = require('@/assets/images/test.webp').toString(); $forceUpdate();"
              outlined></v-text-field>
          </v-card-text>

          <v-divider></v-divider>
          <v-card-actions :color="$vuetify.theme.dark ? 'layout-dark-color-3' : 'grey lighten-5'">
            <v-btn color="primary" text @click="SetDefaultTheme">
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
    <span>{{ $vuetify.theme.dark ? $t('Message.Components.Common.Appbar.ThemeButton.DarkTheme') :
      $t('Message.Components.Common.Appbar.ThemeButton.LightTheme') }}</span>
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
      //dark: this.$vuetify.theme.dark,
      theme_color_select: null,
      locale_theme: {
        primary: colors.blue.base,
        secondary: colors.orange.base,
        accent: colors.pink.base,
        BackgroundImage: '',//require('@/assets/images/test.webp').toString(),
      },
      type: 'hex',
      select_color: '',
    }
  },
  methods: {
    InitTheme() {

      if (this.$store.getters.App.ThemeIsSet) {
        return
      } else {
        this.SetVuetifyDefaultTheme()
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

      if (localStorage.getItem('theme')) {
        var locale_theme = JSON.parse(localStorage.getItem('theme'))
        this.locale_theme.primary = locale_theme.primary
        this.locale_theme.secondary = locale_theme.secondary
        this.locale_theme.accent = locale_theme.accent
        this.locale_theme.BackgroundImage = locale_theme.BackgroundImage

      }


      // else{
      //   this.locale_theme.primary = this.$vuetify.theme.themes.light.primary
      //   this.locale_theme.secondary = this.$vuetify.theme.themes.light.secondary
      //   this.locale_theme.accent = this.$vuetify.theme.themes.light.accent
      //   this.locale_theme.BackgroundImage = ''
      // }

      this.SetTheme()
      // this.SetHtmlWallpaper()
    },
    SetTheme() {
      if (this.$vuetify.theme.dark) {
        this.SetHtmlWallpaper('color', '#2d2d2d')
      } else {
        this.SetHtmlWallpaper('color', '#ffffff')
      }

      this.$vuetify.theme.themes.light = {
        primary: this.locale_theme.primary,
        secondary: this.locale_theme.secondary,
        accent: this.locale_theme.accent,
        //error: colors.red,
      }
      this.$vuetify.theme.themes.dark = {
        primary: this.locale_theme.primary,
        secondary: this.locale_theme.secondary,
        accent: this.locale_theme.accent,
        //error: colors.red,
      }

      if (this.locale_theme.BackgroundImage != '') {
        this.SetHtmlWallpaper('image', this.locale_theme.BackgroundImage)
      } else {
        this.SetHtmlWallpaper('image', '')
      }

      var locale_theme = JSON.parse(localStorage.getItem('theme'))
      if (locale_theme != null) {
        if (locale_theme.BackgroundImage == '') {
          this.$store.getters.App.ThemeButton.ElevateOnScroll = true
        } else {
          this.$store.getters.App.ThemeButton.ElevateOnScroll = false
        }
      }

    },
    SetHtmlWallpaper(mode = '', val = '') {
      //console.log(mode)
      //console.log(val)
      if (mode == 'color') {
        const html = document.querySelector('html');
        html.style.backgroundImage = ''
        html.style.backgroundColor = val
      } else if (mode == 'image') {

        //将html背景图片设置
        const html = document.querySelector('#client');
        //const html = document.querySelector('html');
        if (val == '') {
          //html.style.backgroundImage = ''
          html.style = ''
          return
        }
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
    SetVuetifyDefaultTheme() {
      this.$vuetify.theme.themes.light = {
        primary: colors.blue.base,
        secondary: colors.orange.base,
        accent: colors.pink.base,
        //error: colors.red,
      }
      this.$vuetify.theme.themes.dark = {
        primary: colors.blue.base,
        secondary: colors.orange.base,
        accent: colors.pink.base,
        //error: colors.red,
      }
      // this.$vuetify.theme.themes.dark = {
      //   primary: colors.orange,
      //   secondary: colors.green,
      //   accent: colors.green,
      //   error: colors.red,
      // }
    },
    SetDefaultTheme() {
      this.$vuetify.theme.themes.light = {
        primary: colors.blue.base,
        secondary: colors.orange.base,
        accent: colors.pink.base,
        //error: colors.red,
      }
      this.$vuetify.theme.themes.dark = {
        primary: colors.blue.base,
        secondary: colors.orange.base,
        accent: colors.pink.base,
        //error: colors.red,
      }
      this.locale_theme.primary = this.$vuetify.theme.themes.light.primary
      this.locale_theme.secondary = this.$vuetify.theme.themes.light.secondary
      this.locale_theme.accent = this.$vuetify.theme.themes.light.accent
      this.locale_theme.BackgroundImage = '';//require('@/assets/images/test.webp').toString(),
      //this.SetTheme()
      //this.SaveTheme()
    },
    SaveTheme() {
      localStorage.setItem('theme', JSON.stringify(this.locale_theme))
      this.SetTheme()

    },
  },
  mounted() {
    this.InitTheme()
  },
  computed: {

  },
  watch: {
    '$vuetify.theme.dark': function (val) {
      if (val) {
        this.tab = 1
      } else {
        this.tab = 0
      }
      this.SetTheme()
    },
    // dark(val) {
    //   this.$vuetify.theme.dark = val
    //   this.SetTheme()
    // },
    select_color(val) {
      //将val的后两位去掉
      var vals = val.substring(0, val.length - 2)
      //this.$vuetify.theme.themes.light[this.theme_color_select] = val
      //this.$vuetify.theme.themes.dark[this.theme_color_select] = val
      this.locale_theme[this.theme_color_select] = vals
    },
    theme_color_select(val) {
      this.select_color = this.locale_theme[val] + 'ff'
    },
    locale_theme: {
      handler(val) {

        this.$forceUpdate()

      },
      deep: true,
    },
  },
}
</script>