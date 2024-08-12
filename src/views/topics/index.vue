<template>
  <v-container id="page-topics"
    :style="`max-width: 1084px;${$vuetify.breakpoint.name != 'xs' ? 'padding-top: 12px;' : 'padding-top: 0px;'}`">
    <!-- <v-subheader class="subheading" key="page-topics-subheader" style="margin-top: 4px;">{{
      switchState
    }}</v-subheader> -->
    <!-- <div class="items-wrapper">

      <div id="questions" v-show="$store.getters.App.IsLogin && ($route.hash == '#following' || $route.hash == '')">
        <TopicItem v-for="a in followingData" :key="'following_' + a" :url="`${$G_UrlHeaderLang()}/topics/${a}`"
          @OnItemOpenTopicFollowers="(topic_id) => { users_dialog_id = topic_id; users_dialog_show = true }
            " />
      </div>

      <div id="articles"
        v-show="!$store.getters.App.IsLogin || ($store.getters.App.IsLogin && $route.hash == '#recommended')">
        <TopicItem v-for="a in recommendedData" :key="'recommended_' + a" :url="`${$G_UrlHeaderLang()}/topics/${a}`"
          @OnItemOpenTopicFollowers="(topic_id) => { users_dialog_id = topic_id; users_dialog_show = true }
            " />
      </div>
    </div> -->
    <v-tabs-items v-model="tab" class="layout-colourless">
      <v-tab-item value="following">
        <Contexts v-if="tab=='following'" :subtitle="'Message.Pages.Topics.FollowedNTopic'" :show_total="true" :type="'following'" />
      </v-tab-item>
      <v-tab-item value="recommended">
        <Contexts v-if="tab=='recommended'" :subtitle="'Message.Pages.Topics.RecommendedTopics'" :show_total="false" :type="'recommended'" />
      </v-tab-item>
    </v-tabs-items>

    <TopicsDialog/>
    
    <UsersDialog :id="users_dialog_id" :show="users_dialog_show" :type="users_dialog_type"
      @OnUsersDialogClose="users_dialog_show = false" />
  </v-container>
</template>
<script>
// import TopicItem from '@/components/topic-item/index.vue';
// import Loading from '@/components/loading/index.vue'
import UsersDialog from '@/components/users-dialog/index.vue'
import TopicsDialog from '@/components/topics-dialog/index.vue'
import Contexts from './components/contexts/index.vue'
export default {
  name: 'page-topics',
  components: {
    // TopicItem,
    // Loading,
    UsersDialog,
    TopicsDialog,
    Contexts,
  },
  data: () => ({
    followingData: [1, 2, 3, 4, 5],
    recommendedData: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    subheader: "Message.Pages.Topics.HeaderTitle",
    IsLoading: false,
    users_dialog_id: 0,
    users_dialog_show: false,
    users_dialog_type: 'topic_followers',
    questions_handleScroll_cache: false,
    articles_handleScroll_cache: false,
    tab: 'following',
  }),
  // computed: {
  //   switchState() {
  //     if (!this.$store.getters.App.IsLogin) {
  //       return this.$t("Message.Pages.Topics.HeaderTitle")
  //     } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#recommended') {
  //       this.tab = 'recommended'
  //       return this.$t("Message.Pages.Topics.HeaderTitle")
  //     } else if (this.$store.getters.App.IsLogin && (this.$route.hash == '#following' || this.$route.hash == '')) {
  //       this.tab = 'following'
  //       var a = this.$t("Message.Pages.Topics.FollowedNTopic")
  //       return a.replace("%s", this.followingData.length)
  //     }
  //   }
  // },
  methods: {
    TestPrint() {
      console.log('TestPrint')
    },
    SwitchWebTitle(to) {
      if (to.path == `${this.$G_UrlHeaderLang()}/topics`) {
        this.$G_SetWebSubTitle('Message.Pages.Topics.WebSubTitle', true)
        if (this.$store.getters.App.IsLogin && (to.hash == '#following' || to.hash == '')) {
          this.tab = 'following'
          this.$G_SetWebSubTitle('Message.Pages.Topics.TheTopicIAmFollowing')
        } else if ((!this.$store.getters.App.IsLogin && to.hash == '') || (this.$store.getters.App.IsLogin && to.hash == '#recommended')) {
          this.tab = 'recommended'
          this.$G_SetWebSubTitle('Message.Pages.Topics.RecommendedTopics')
        }
      }
    }
  },
  watch: {
    '$route'(to, from) {
      this.SwitchWebTitle(to)
    }
  },
  mounted() {
    this.SwitchWebTitle(this.$route)
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';

#page-topics,
#page-users {
  .subheading {
    padding: 8px 8px 16px;
    font-weight: 400;
    font-size: 15px;
    letter-spacing: 0.04em;

    @media (min-width: @screen-sm-min) {
      padding-bottom: 24px;
      font-size: 16px;
    }
  }

  .items-wrapper {
    margin-right: 0;
    margin-left: 0;

    &::after {
      display: table;
      clear: both;
      content: "";
    }

    @media (min-width: @screen-sm-min){//300px) {
      margin-right: -8px;
      margin-left: -8px;
    }
  }

  .item-inner {
    position: relative;
    float: left;
    box-sizing: border-box;
    width: 50%;

    &:nth-child(odd) {
      padding-right: 4px;
      padding-left: 8px;
    }

    &:nth-child(even) {
      padding-right: 8px;
      padding-left: 4px;
    }

    @media (min-width: @screen-sm-min) {
      width: 33.333333%;
      padding-right: 8px !important;
      padding-left: 8px !important;
    }

    @media (min-width: @screen-md-min) {
      width: 25%;
    }
  }

  .mc-follow {
    min-width: 0;
    padding: 0 8px;
  }
}</style>