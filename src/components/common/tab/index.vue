<template>
  <v-tabs id="common-tabs" show-arrows :grow="
    $store.getters.App.UserSelectDeviceType == 'mobile'||$vuetify.breakpoint.name=='xs'
    ">
    <v-tabs-slider color="primary"></v-tabs-slider>
    <v-tab v-for="(items, index) in item" :key="items.hash" :to="items.hash"
      v-if="items.needLogin == $store.getters.App.IsLogin || !items.needLogin"
      @click="OnTabbarClickCallback(items.text, index)">
      {{ 
        $t(items.text)
      }}
    </v-tab>
  </v-tabs>
</template>
<script>
export default {
  name: 'tab',
  props: {
    item: Array,
  },
  data: () => ({
  }),
  methods: {
    OnTabbarClickCallback(text, index) {
      this.$emit('OnTabbarClickCallback', text, index)
    }
  }
}
</script>
<style lang="less">
#page-topic,
#page-user {
  .v-tabs-bar {
    background-color: #00000000 !important;
  }
  .theme--dark & {
    .v-tab--active {
      color: #ffffff;
    }
  }
}

</style>