<template>
  <div class="mc-comments-page">
    <ListHeader title="Message.Pages.Question.NAnswers" key="Contexts_4" :item="list_header"
      @OnMenuClickCallback="" />
    <Comments 
    :show_new_comment="false" 
    :external_loading="external_loading" 
    :need_glass_container="true"
    item_classes="layout-colourless"
    />
    <div :class="[
      'new-comment-fixed',
    ]"
    :style="{
      'transition':'transform 0.3s ease, opacity 0.3s ease',
      'margin-left':$store.getters.App.UserSelectDeviceType=='pc'&&$store.getters.App.Drawer.Show
      ?
        '256px'
      :
        (
          $store.getters.App.UserSelectDeviceType=='pad'&&$store.getters.App.Drawer.Show
          ?
            '86px'
          :
            ''
        )
      ,
      'bottom':$store.getters.App.UserSelectDeviceType=='mobile'?'56px':'0',
      'transform':$store.getters.App.AddFab.ScrollMode=='down'&&!$store.getters.App.AddFab.NewComment_Select?'translateY(100%)':'none',
      'opacity':$store.getters.App.AddFab.ScrollMode=='down'&&!$store.getters.App.AddFab.NewComment_Select?'0':'',
    }">
      <div class="container" >
        <NewComment :show="true" @OnFocus="$store.getters.App.AddFab.NewComment_Select=true" @OnBlur="$store.getters.App.AddFab.NewComment_Select=false"/>
      </div>
    </div>
  </div>
</template>
<script>
import Comments from '@/components/comments/index.vue'
import ListHeader from '@/components/list-header/index.vue'
import NewComment from '@/components/comments/components/new-comment/index.vue'
export default{
  name: 'comments-page',
  props:{
    external_loading:{
      type:Boolean,
      default:false,
    },
  },
  components: {
    Comments,
    ListHeader,
    NewComment,
  },
  data: () => ({
    //NewComment_Select: false,
    list_header: [
      {
        order: '-update_time',
        name: 'Message.Pages.Topic.Contexts.UpdateTime_FromLateToEarly',
      },
      {
        order: 'update_time',
        name: 'Message.Pages.Topic.Contexts.UpdateTime_FromEarlyToLate',
      },
      {
        order: '-vote_count',
        name: 'Message.Pages.Topic.Contexts.Hottest',
      },
    ],
    show_self_new_comment: false,
  }),
  // watch:{
  //   '$store.getters.App.AddFab.ScrollMode'(val){
  //     console.log(val)
  //     if(val=='down'){
  //       this.show_self_new_comment = false
  //     }else{
  //       this.show_self_new_comment = true
  //     }
  //   }
  // }
  // mounted() {
  //   window.addEventListener('scroll', this.handleScroll)
  // },
  // methods: {
  //   handleScroll() {
  //     if (this.lastScrollTop > window.scrollY) {
  //       this.show_self_new_comment = true
  //     } else {
  //       this.show_self_new_comment = false
  //     }
  //   },
  // },
}
</script>
<style lang="less">
@import "../../vendor/variable.less";
.mc-comments-page {
  .mc-list-header {
    margin-top: 32px;
    margin-bottom: 20px;
    @media (max-width: @screen-xs-max) {
      margin-top: 20px;
      margin-bottom: 12px;
      padding: 0 16px;
    }
  }
  .comments-wrapper {
    margin-bottom: 16px;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, .12);
    border-radius: 8px;
    .theme--dark & {
      border-color: rgba(255, 255, 255, .12);
    }
    .mc-loaded {
      margin-bottom: 24px !important;
    }
    @media (max-width: @screen-xs-max) {
      border-right: none;
      border-left: none;
      border-radius: 0;
    }
  }
  .comments {
    border: none;
  }
  .new-comment-fixed {
    position: fixed;
    bottom: 0;
    //position: fixed;
    right: 0;
    left: 0;
    .container {
      max-width: 846px;
      padding-top: 0;
      padding-bottom: 0;
      @media (max-width: @screen-xs-max) {
        padding: 0;
      }
    }
    .new-comment {
      box-sizing: border-box;
      padding-right: 64px !important;
      padding-left: 64px !important;
      border-right: 1px solid rgba(0, 0, 0, .12);
      border-left: 1px solid rgba(0, 0, 0, .12);
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      box-shadow: 0 -1px 3px rgba(26, 26, 26, 0.1);
      .theme--dark & {
        border-top-color: rgba(255, 255, 255, .12);
      }
      @media (max-width: @screen-xs-max) {
        padding-right: 16px !important;
        padding-left: 16px !important;
        border-right: none;
        border-left: none;
        border-radius: 0;
      }
    }
  }
}
</style>