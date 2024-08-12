<template>
  <v-tooltip top :disabled="$vuetify.breakpoint.name != 'xs'">
    <template v-slot:activator="{ on, attrs }">
      <v-fab-transition>
        <v-btn 
          v-show="AddFabButtonShowRule" 
          elevation="8" 
          :style="{
            // 'margin-bottom': $store.getters.App.UserSelectDeviceType == 'mobile'&&$store.getters.App.NavFooter.Show ? '56px' : '0px',
            // 'margin-right': $store.getters.App.AddFab.ShowScrollTopBtn ? ($vuetify.breakpoint.name == 'xs' ? '80px' : '70px') : '0px',
            'transform': $store.getters.App.UserSelectDeviceType == 'mobile' && $store.getters.App.NavFooter.Show
              ?
              //'translateY(-56px)'
              $store.getters.App.AddFab.ShowScrollTopBtn
                ?
                'translateY(-56px) translateX(-80px)'
                :
                'translateY(-56px)'
              :
              //'0px'
              $store.getters.App.AddFab.ShowScrollTopBtn
                ?
                ($vuetify.breakpoint.name == 'xs' ? 'translateX(-80px)' : 'translateX(-70px)')
                :
                ''
            ,
          }" 
          :x-large="$vuetify.breakpoint.name != 'xs'" 
          :rounded="$vuetify.breakpoint.name != 'xs'"
          :fab="$vuetify.breakpoint.name == 'xs'" 
          fixed large bottom right 
          color="primary" 
          v-bind="attrs" 
          v-on="on"
          @click="
            $store.getters.App.IsLogin 
            ? OnClick() 
            : $store.getters.App.Dialog.Login = true
          "
        >
          <v-icon 
          :style="{
            'transform': $store.getters.App.AddFab.ShowScrollTopBtn
            ?$store.getters.App.UserSelectDeviceType == 'mobile' 
              ? 'rotate(360deg)' 
              : ''
            :$store.getters.App.UserSelectDeviceType == 'mobile' 
              ? 'rotate(0deg)' 
              : ''
          }"
          >
            <!-- mdi-plus -->
            {{ AddFabIcon }}
          </v-icon>
          <span v-show="$vuetify.breakpoint.name != 'xs'">{{
            AddFabText
          }}</span>
        </v-btn>
      </v-fab-transition>
    </template>
    <span>{{
      AddFabText
    }}</span>
  </v-tooltip>
</template>
<script>
export default {
  name: 'add-fab-button',
  data: () => ({
    AddFabText: '',
    AddFabIcon: '',
  }),
  computed: {
    AddFabButtonShowRule() {
      if (this.$route.path.indexOf(`${this.$G_UrlHeaderLang()}/topics`) != -1) {
        return true
      } else if (this.$route.path == `${this.$G_UrlHeaderLang()}/questions` && (this.$store.getters.App.Editor.State == 'close' || this.$store.getters.App.Editor.State == 'minimize')) {
        return true
      } else if (this.$route.path.indexOf(`${this.$G_UrlHeaderLang()}/questions/`) != -1 && (this.$store.getters.App.Editor.State == 'close' || this.$store.getters.App.Editor.State == 'minimize')) {
        return true
      } else if (this.$route.path == `${this.$G_UrlHeaderLang()}/articles` && (this.$store.getters.App.Editor.State == 'close' || this.$store.getters.App.Editor.State == 'minimize')) {
        return true
      }
      return false
    },
  },
  methods: {
    AddFabButtonTextRules() {
      if (this.$route.path == `${this.$G_UrlHeaderLang()}/questions`||this.$route.hash.indexOf('questions') != -1 ||(this.$route.path.indexOf('/topics/') != -1 &&this.$route.hash == '')) {

        this.$store.state.App.Editor.Mode = 'question'
        
        this.AddFabIcon='mdi-forum-plus-outline'

        if (localStorage.getItem('questions_cache')&&this.$store.getters.App.IsLogin ) {
          return `${this.$t('Message.Components.AddFabButton.Continue')}${this.$t('Message.Components.AddFabButton.WriteAskAQuestion')}`
        } else {
          return this.$t('Message.Components.AddFabButton.WriteAskAQuestion')
        }

      } else if (this.$route.path.indexOf('/articles') != -1 ||this.$route.hash.indexOf('articles') != -1 ||(this.$route.path.indexOf('/topics/') != -1 && this.$route.hash == '#articles')) {

        this.$store.state.App.Editor.Mode = 'articles'

        this.AddFabIcon='mdi-file-plus-outline'

        if (localStorage.getItem('articles_cache')&&this.$store.getters.App.IsLogin) {
          return `${this.$t('Message.Components.AddFabButton.Continue')}${this.$t('Message.Components.AddFabButton.WriteAnArticle')}`
        } else {
          return this.$t('Message.Components.AddFabButton.WriteAnArticle')
        }

      } else if (this.$route.path.indexOf('/questions/') != -1) {

        
        this.$store.state.App.Editor.Mode = 'answer'

        this.AddFabIcon='mdi-comment-plus-outline'

        if (localStorage.getItem('answer_cache')&&this.$store.getters.App.IsLogin) {
          return `${this.$t('Message.Components.AddFabButton.Continue')}${this.$t('Message.Components.AddFabButton.WriteAnAnswer')}`
        } else {
          return this.$t('Message.Components.AddFabButton.WriteAnAnswer')
        }

      } else if (this.$route.path == `${this.$G_UrlHeaderLang()}/topics`) {
        this.AddFabIcon='mdi-book-plus-outline'
        return this.$t('Message.Components.AddFabButton.NewTopic')
      }
    },
    OnClick() {
      if (this.$route.path == `${this.$G_UrlHeaderLang()}/topics`) {
        this.$store.getters.App.Dialog.NewTopic = true
      } else {
        this.$store.getters.App.Editor.State = 'open'
      }
    }
  },
  watch: {
    '$store.getters.App.Editor.State': {
      handler(val) {
        this.AddFabText = this.AddFabButtonTextRules()
      },
      immediate: true,
    },
    $route: {
      handler(val) {
        this.AddFabText = this.AddFabButtonTextRules()
      },
      immediate: true,
    },
  }
}
</script>