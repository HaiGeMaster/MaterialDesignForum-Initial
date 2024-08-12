<template>
  <v-container id="page-article"
    :style="$vuetify.breakpoint.name != 'xs' ? 'padding:0 12px;' : 'padding:0 0px;'">
    <BackButton />
    <v-card 
      :class="[
        'glass-container',
        'article',
        `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
      ]"
      :rounded="$vuetify.breakpoint.name != 'xs'" :outlined="$vuetify.theme.dark" :style="{
        'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
      }">
      <h1 class="title">标题</h1>
      <UserLine />
      <!-- <TipTapEditor class="content" :editable="false" /> -->
      <div class="mc-topics-bar"></div>
      <!-- <div class="actions">
        <Vote />
        <div style="margin-left: 16px;"></div>
        <Follow />
        <v-spacer></v-spacer>
        <OptionsButton />
      </div> -->
      <v-divider></v-divider>
      <v-card-actions>
        <Vote />
        <Follow />
        <v-spacer></v-spacer>
        <OptionsButton />
      </v-card-actions>
    </v-card>
    <CommentsPage :external_loading="true"/>
  </v-container>
</template>
<script>
import BackButton from '@/components/back-button/index.vue'
import UserLine from '@/components/user-line/index.vue'
import Follow from '@/components/follow/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
// import TipTapEditor from '@/components/tiptap-editor/index.vue'
import Vote from '@/components/vote/index.vue'
import CommentsPage from '@/components/comments/comments-page.vue'
export default {
  name: 'page-article',
  components: {
    BackButton,
    UserLine,
    Follow,
    // TipTapEditor,
    OptionsButton,
    Vote,
    CommentsPage,
  },
  data: () => ({
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
#page-article {
  max-width: 846px;
  .article {
    border-color:#e0e0e0;
    .theme--dark & {
      border-color:#494949;
    }
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
    }
    .mc-follow {
      margin-left: 16px;
    }
  }
  .mc-list-header {
    margin-top: 32px;
    margin-bottom: 20px;
  }
  @media (max-width: @screen-xs-max) {
    .article {
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
  }
}
</style>