<template>
  <v-tabs
    :centered="
      $store.getters.App.UserSelectDeviceType != 'pad' &&
      $store.getters.App.UserSelectDeviceType != 'mobile'
    "
    :key="'tabbar' + path"
    show-arrows
    :grow="$store.getters.App.UserSelectDeviceType == 'mobile'||$vuetify.breakpoint.name=='xs'"
    class="layout-colourless"
    v-model="$store.getters.App.Appbar.Tabbar">
    <v-tabs-slider color="primary"></v-tabs-slider>
    <v-tab
      v-for="(items, index) in item"
      :to="`${$G_UrlHeaderLang()}${items.link}`"
      :key="index"
      v-if="$route.path == path && ((items.needLogin && $store.getters.App.IsLogin) || !items.needLogin)"
      @click="outputroute"
      class="layout-colourless"
      >
      {{ $t(items.name) }}
    </v-tab>
  </v-tabs>
</template>
<script>
export default {
  props:{
    item: Array,
    path: String,
  },
  data() {
    return {
      tab: null,
      topics_tab: null,
      questions_tab: null,
      articles_tab: null,
      users_tab: null,
      topics_text: 'Test',
    }
  },
  methods: {
    outputroute() {
    }
  },
  watch: {
    tab(val) {
      this.$store.getters.App.Appbar.Tabbar = val
    },
  }
}
</script>