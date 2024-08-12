<template>
  <div key="mc-loading" class="mc-loading" v-show="show">
    <v-progress-circular v-show="show" indeterminate color="primary" class="mc-spinner"></v-progress-circular>
  </div>
</template>
<script>
export default {
  name: 'loading-ring',
  props:{
    show: {
      type: Boolean,
      default: false,
    },
  }
}
</script>
<style lang="less">
.mc-loading {
  display: block;
  padding: 17px 0;
  .mc-spinner {
    display: block;
    margin: 0 auto;
  }
}
</style>