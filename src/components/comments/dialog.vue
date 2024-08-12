<template>
  <v-dialog
    v-model="dialog"
    max-width="750px"
  >
    <v-card
    :class="[
      'mc-comments-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : 'rounded-0'}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'"
    >
    <ListHeader :show_close="true" title="Message.Pages.Question.NAnswers" key="Contexts_4" class="mc-list-header"
      @OnMenuClickCallback=""
      @OnCloseClickCallback="dialog = !dialog"
      />
      <Comments @OnCloseClickCallback="dialog=false" 
      :need_glass_container="false" 
      item_classes="layout-colourless"
      new_comment_rounded_t_or_b="b"
      :need_rounded="false"
      />
    </v-card>
  </v-dialog>
</template>
<script>
import ListHeader from '@/components/list-header/index.vue'
import Comments from '@/components/comments/index.vue'
export default {
  name: 'comments-dialog',
  components: {
    ListHeader,
    Comments,
  },
  data() {
    return {
      dialog: true,
    }
  },
  watch:{
    dialog(val){
      if(!val){
        this.$emit('OnCloseDialogCallback')
      }
    }
  }
}
</script>
<style lang="less">
@import "../../vendor/variable.less";
.mc-comments-dialog {
  position: fixed;
  top: 3%;
  z-index: 2001;
  max-width: 750px;
  width:94%;
  height: 100vh;
  max-height: 94%;
  @media (max-width: @screen-xs-max) {
    top: 0;
    left: 0;
    width: 100%;
    max-height: 100%;
    border-radius: 0;
  }
  .mc-comments {
    height: 100%;
  }
  .mc-list-header {
    display: flex;
    align-items: center;
    box-sizing: border-box;
    height: 60px;
    margin: 0 !important;
    padding: 0 16px;
    border-bottom: 1px solid rgba(0, 0, 0, .12);
    .close {
      display: none;
    }
    button {
      padding-right: 0;
    }
    .theme--dark & {
      border-bottom-color: #494949
    }
    @media (max-width: @screen-sm-max) {
      height: 56px;
    }
    @media (max-width: @screen-xs-max) {
      padding-left: 8px;
      .close {
        display: inline-block;
        margin-right: 16px;
      }
    }
  }
  .comments-wrapper {
    height: calc(~'100% - 120px');
    overflow: auto;
    -webkit-overflow-scrolling: touch;
    @media (max-width: @screen-sm-max) {
      height: calc(~'100% - 116px');
    }
    .mc-loaded {
      margin-bottom: 24px !important;
    }
  }
  .comments {
    border-top: none;
    border-right: none;
    border-left: none;
    border-radius: 0;
  }
  .mc-comments > .new-comment {
    position: absolute;
    bottom: 0;
    box-shadow: 0 -1px 3px rgba(26, 26, 26, .1);
    .theme--dark & {
      box-shadow: 0 -1px 3px rgba(228, 228, 228, .1);
    }
  }
  .comments > .item,
  .mc-comments > .new-comment {
    padding-right: 24px;
    padding-left: 24px;
    @media (max-width: @screen-xs-max) {
      padding-right: 16px;
      padding-left: 16px;
    }
  }
}
</style>