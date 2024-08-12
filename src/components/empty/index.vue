<template>
  <div class='mc-empty' key="mc-empty" v-show="show">
    <div class="title">{{ $t(title) }}</div>
    <div class="description">{{ $t(description) }}</div>
    <v-btn @click="$emit('OnClick')" v-show="action_show" color="primary">{{ $t(action_text) }}</v-btn>
  </div>
</template>
<script>
export default {
  name: 'empty',
  props:{
    show: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: 'Message.Components.Empty.Title',
    },
    description: {
      type: String,
      default: 'Message.Components.Empty.Description',
    },
    action_text: {
      type: String,
      default: 'Message.Components.Empty.BackHome',
    },
    action_show: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
  }),
  created() {
  },
}
</script>
<style lang="less">
.mc-empty {
  box-sizing: border-box;
  width: 100%;

  border-radius: 8px;

  margin-top: 50px;//80px;
  padding: 108px 16px 64px;
  text-align: center;
  // background-image: url("~@/assets/images/following_empty.png");
  background-image: url("~@/assets/images/test.webp");
  background-repeat: no-repeat;
  background-position: center top;
  //背景图片上边距
  //background-size: 100% 100%;
  .title {
    margin-bottom: 20px;
    color: rgba(0, 0, 0, .54);
    font-size: 18px;
    .theme--dark & {
      color: rgba(255, 255, 255, .87);
    }
  }
  .description {
    margin-bottom: 20px;
    color: rgba(0, 0, 0, .54);
    font-size: 15px;
    line-height: 24px;
    .theme--dark & {
      color: rgba(255, 255, 255, .64);
    }
  }
}</style>