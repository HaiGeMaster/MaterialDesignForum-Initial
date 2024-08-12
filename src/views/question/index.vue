<template>
  <v-container id="page-question"
    :style="$vuetify.breakpoint.name != 'xs' ? 'padding:0 12px;' : 'padding:0 0px;'">
    <BackButton />
    <v-card 
      :class="[
        'glass-container',
        'question',
        `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
      ]"
      :rounded="$vuetify.breakpoint.name != 'xs'" :outlined="$vuetify.theme.dark" :style="{
        'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
        'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
      }">
      <h1 class="title">标题</h1>
      <UserLine />
      <!-- <TipTapEditor class="content" :editable="false" /> -->
      <div class="mc-topics-bar"></div>
      <div class="actions">
        <Follow />
        <div style="margin-left: 16px;"></div>
        <CommentButton @OnCommentButtonClick="OnCommentButtonClick" />
        <v-spacer></v-spacer>
        <OptionsButton />
      </div>
    </v-card>
    <AnswersPage />
    <!-- <MdEditor /> -->
    <Loading :loading="IsLoading" />
    <CommentsDialog external_loading="false"/>
  </v-container>
</template>
<script>
import BackButton from '@/components/back-button/index.vue'
import UserLine from '@/components/user-line/index.vue'
import Follow from '@/components/follow/index.vue'
import CommentButton from '@/components/comments/components/comment-button/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
import AnswersPage from '@/components/answers/answers-page.vue'
import Loading from '@/components/loading/index.vue'
// import TipTapEditor from '@/components/tiptap-editor/index.vue'
// import MdEditor from '@/components/md-editor/index.vue'
import CommentsDialog from '@/components/comments/dialog.vue'
export default {
  name: 'page-question',
  components: {
    BackButton,
    UserLine,
    Follow,
    // TipTapEditor,
    CommentButton,
    OptionsButton,
    AnswersPage,
    Loading,
    CommentsDialog,
    //MdEditor,
  },
  data: () => ({
    IsLoading: false,
  }),
  methods: {
    OnCommentButtonClick() {
      console.log('OnCommentButtonClick')
    }
  }
}
</script>
<style lang="less">
@import "../../vendor/variable.less";
#page-question {
  max-width: 846px;
  .question {
    padding: 0 64px;
    .title {
      position: relative;
      margin: 0;
      padding: 36px 0 24px;
      font-weight: normal;
      font-size: 24px;
      line-height: 36px;
    }
    .content {
      padding: 48px 0 32px;
    }
    .mc-topics-bar {
      padding-bottom: 16px;
    }
    .actions {
      display: flex;
      margin-right: -64px;
      margin-left: -64px;
      padding: 8px 64px;
      background-color: rgba(0, 0, 0, .04);
      .theme--dark & {
        background-color: rgba(255, 255, 255, .02);
      }
    }
  }
  .mc-list-header {
    margin-top: 32px;
    margin-bottom: 20px;
  }
  .all-answers {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    margin: 16px 0;
    text-decoration: none;
    border: 1px solid rgba(0, 0, 0, .12);
    border-radius: 8px;
    opacity: .56;
    .theme--dark & {
      border-color: rgba(255, 255, 255, .12);
    }
    &:hover {
      opacity: 1;
    }
  }
  .answers {
    min-height: 148px;
  }
  @media (max-width: @screen-xs-max) {
    .question {
      padding: 0 16px;
      border-right: none;
      border-left: none;
      border-radius: 0;
      .title {
        padding: 16px 0;
        font-size: 22px;
        line-height: 32px;
      }
      .content {
        padding: 28px 0;
      }
      .mc-topics-bar {
        padding-bottom: 8px;
      }
      .actions {
        margin-right: -16px;
        margin-left: -16px;
        padding-right: 16px;
        padding-left: 16px;
      }
    }
    .mc-list-header {
      margin-top: 20px;
      margin-bottom: 12px;
      padding: 0 16px;
    }
    .answers {
      border-right: none;
      border-left: none;
      border-radius: 0;
    }
  }
}
</style>