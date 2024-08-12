<template>
  <div style="margin-top: 4px;">
    <v-subheader class="subheading" v-if="!IsEmpty && data != null">{{
      show_total ? $t(subtitle).replace("%s", pagination.total) : $t(subtitle)
    }}</v-subheader>
    <div class="items-wrapper" v-if="!IsEmpty && data != null">
      <TopicItem v-for="t in data" :url="`${$G_UrlHeaderLang()}/topics/${t}`" @OnItemOpenTopicFollowers="" />
    </div>
    <Empty :show="IsEmpty || data == null" :title="type == 'following'
        ?
        'Message.Pages.Topics.NotFollowingAnyTopicsYet'
        :
        'Message.Pages.Topics.NoTopicAtTheMoment'
      " :description="type == 'following'
    ?
    'Message.Pages.Topics.AfterFollowingTheTopicTheCorrespondingTopicWillBeDisplayedHere'
    :
    'Message.Pages.Topics.NoManagersHaveCreatedNewTopics'
    " :action_text="type == 'following'
    ?
    'Message.Pages.Topics.ViewSelectedTopics'
    : ''
    " :action_show="type == 'following'"
      @OnClick="() => { this.$router.push(`${this.$G_UrlHeaderLang()}/topics#recommended`) }" />
    <Loading v-if="!IsEmpty" :loading="IsLoading" :pagination="pagination"
      @OnElementEntryViewport="OnElementEntryViewport" />
  </div>
</template>
<script>
import TopicItem from '@/components/topic-item/index.vue';
import Loading from '@/components/loading/index.vue'
import Empty from '@/components/empty/index.vue'
export default {
  name: 'page-topics-content',
  props: {
    subtitle: {
      type: String,
      default: '',
    },
    show_total: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'recommended',//following, recommended
    },
  },
  components: {
    TopicItem,
    Loading,
    Empty,
  },
  data: () => ({
    IsLoading: false,
    IsEmpty: false,
    data: [1],
    pagination: {
      page: 0,
      per_page: 20,
      total: 0,
      pages: 0,
      previous: 0,
      next: 1
    },
  }),
  methods: {
    OnElementEntryViewport(isEntry) {
      if (this.$route.path != `${this.$G_UrlHeaderLang()}/users`) {
        return
      }
      if (this.IsLoading) {
        return
      }
      if (isEntry) {
        this.IsLoading = true
        this.GetTopics()
      }
    },
    GetTopics() {
      var token = this.$store.getters.App.UserToken || localStorage.getItem('token') || this.$cookies.get('token') || ''
      this.$axios.post('/api/topics', {
        type: this.type,
        page: this.pagination.next,
        user_token: token != '' ? token : '',
      }
      ).then(response => {
        if (response.data.is_get == true) {
          this.data == null ? this.data = response.data.data : response.data.data.forEach((item, index) => {
            //如果item.user_id在this.data 中存在则不添加
            var index = this.data.findIndex(item2 => item2.user_id === item.user_id);
            // 如果找到相同的项，isExist 为 true
            var isExist = index !== -1;
            if (!isExist) {
              this.data.push(item)
            }
          })
          this.pagination = response.data.pagination
          if (response.data.pagination.total == 0) {
            //console.log('IsEmpty:true')
            this.IsEmpty = true
            this.$emit('OnIsEmpty', true)
          } else {
            //console.log('IsEmpty:false')
            this.IsEmpty = false
            this.$emit('OnIsEmpty', false)
          }
        }
        this.IsLoading = false
      }).catch(error => {
        this.IsLoading = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      })
    }
  },
}
</script>