<template>
  <v-app-bar app id="search-v-app-bar" class="glass-container"
    :elevate-on-scroll="$store.getters.App.ThemeButton.ElevateOnScroll"
    :clipped-left="$store.getters.App.UserSelectDeviceType == 'pad' || $store.getters.App.UserSelectDeviceType == 'pc'"
    elevation="1"
    :style="$store.getters.App.UserSelectDeviceType == 'pad' && $store.getters.App.Drawer.Show ? 'margin-left:86px;' : ''">
    <v-text-field v-model="SearchText" 
    prepend-inner-icon="mdi-magnify" 
    @click:prepend-inner="OnStartSearchCallback"
    append-icon="mdi-close"
      @click:append="OnCloseSearchCallback" :background-color="$vuetify.theme.dark ? 'layout-dark-color-3' : ''"
      :label="$t('Message.Components.Common.Appbar.Search.Search')" single-line hide-details rounded solo flat
      @keydown="OnStartSearchCallback"></v-text-field>
    <!-- <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on" @click="OnCloseSearchCallback">
          <v-icon>
            mdi-close
          </v-icon>
        </v-btn>
      </template>
      <span>{{ $t('Message.Components.Common.Appbar.Search.SearchClose') }}</span>
    </v-tooltip> -->
  </v-app-bar>
</template>
<script>
export default {
  name: 'search',
  data: () => ({
    SearchText: '',
  }),
  methods: {
    OnCloseSearchCallback() {
      this.$emit('OnCloseSearchCallback', false)
    },
    OnStartSearchCallback(val) {
      if (val.keyCode === 13) {
        this.OnCloseSearchCallback()
        this.$emit('OnStartSearchCallback', this.SearchText)
      }
    },
  },
  watch: {
    '$vuetify.breakpoint.name': {
      handler(val) {
        if (val != 'xs' && val != 'sm') {
          this.OnCloseSearchCallback()
        }
      },
    },
  },
}
</script>
<style lang="less">
#search-v-app-bar {
  .v-text-field--solo>.v-input__control>.v-input__slot {
    background-color: inherit !important;
  }
}
</style>