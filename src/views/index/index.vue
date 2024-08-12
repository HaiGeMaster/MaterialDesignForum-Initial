<template>
  <v-container id="page-index"
    :style="$vuetify.breakpoint.name != 'xs' ? 'max-width: 1100px;padding:0 12px;' : 'max-width: 1100px;padding:0 0px;'">
    <Header :title="$t('Message.Pages.Index.HeaderTitle')" :url="$store.getters.App.IsLogin ? `${$G_UrlHeaderLang()}/topics#recommended` : `${$G_UrlHeaderLang()}/topics`
      " />
    <Topics @OnItemOpenTopicFollowers="
    (topic_id)=>{users_dialog_id=topic_id;users_dialog_show=true}
    "/>
    <div class="items-wrapper">
      <Items :header_url="`${$G_UrlHeaderLang()}/questions`" :title="$t('Message.Pages.Index.LatestQuestions')" item_type="questions"/>
      <Items :header_url="`${$G_UrlHeaderLang()}/questions#popular`" :title="$t('Message.Pages.Index.RecentlyPopularQuestions')" item_type="questions" />
    </div>
    <div class="items-wrapper" :style="$store.getters.App.ShowScrollTopBtn ? 'margin-bottom: 90px;' : ''">
      <Items :header_url="`${$G_UrlHeaderLang()}/articles`" :title="$t('Message.Pages.Index.LatestArticles')" item_type="articles" />
      <Items :header_url="`${$G_UrlHeaderLang()}/articles#popular`" :title="$t('Message.Pages.Index.RecentlyPopularArticles')" item_type="articles" />
    </div>
    <Loading :loading="IsLoading" />
    <UsersDialog :id="users_dialog_id" :show="users_dialog_show" :type="users_dialog_type" @OnUsersDialogClose="users_dialog_show=false"/>
  </v-container>
</template>
<script>
import Header from './components/header/index.vue'
import Topics from './components/topics/index.vue'
import Items from './components/items/index.vue'
import UsersDialog from '@/components/users-dialog/index.vue'
import Loading from '@/components/loading/index.vue'
export default {
  name: 'page-index',
  components: {
    Header,
    Topics,
    Items,
    UsersDialog,
    Loading,
  },
  data: () => ({
    users_dialog_id:0,
    users_dialog_show:false,
    users_dialog_type:'topic_followers',
    IsLoading:false,
  }),
  watch:{
    '$route'(to, from) {
      if(to.path==`${this.$G_UrlHeaderLang()}/`){
        this.$G_SetWebSubTitle('Message.Pages.Index.WebSubTitle',true)
      }
    }
  },
  created() {
    this.$G_SetWebSubTitle('Message.Pages.Index.WebSubTitle',true)
  },
  methods:{
    OnItemOpenTopicFollowers(topic_id){
      this.users_dialog_id=topic_id
      this.users_dialog_show=true
    }
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
#page-index {
  &v-container {
    padding-top: 0;
  }
  &>.header {
    margin: 0 8px;
    padding: 4px 4px 0 !important;
    @media (max-width: @screen-xs-max) {
      margin: 0;
      padding: 0 16px !important;
    }
  }
  .topics-wrapper {
    margin-bottom: 20px;
  }
  .items-wrapper {
    &::after {
      display: table;
      clear: both;
      content: '';
    }
  }
}
</style>