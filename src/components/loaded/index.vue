<template>
  <div v-show="show" class="mc-loaded" key="mc-loaded">
    {{ $t('Message.Components.Loaded.AllDataHasBeenLoaded') }}
  </div>
</template>
<script>
export default {
  name: 'loaded',
  props:{
    show: {
      type: Boolean,
      default: true,
    },
  },
}
</script>
<style lang="less">
.mc-loaded {
  //margin: 24px 0 -38px !important;
  padding: 8px;
  border-radius: 8px;
  font-size: 13px;
  letter-spacing: .5px;
  text-align: center;
  opacity: .54;
  color: gray;
  //宽度根据字体大小自适应
  width: fit-content;
  //左右居中
  margin: 0 auto;
  .theme--dark & {
    color: gray;
  }
}
</style>