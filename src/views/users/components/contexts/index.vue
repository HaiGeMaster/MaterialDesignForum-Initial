<template>
  <div style="margin-top: 4px;">
    <v-subheader class="subheading" v-if="!IsEmpty&&data!=null">{{
      show_total ? $t(subtitle).replace("%s", pagination.total) : $t(subtitle)
    }}</v-subheader>
    <div class="items-wrapper" v-if="!IsEmpty&&data!=null">
      <UserItem v-for="u in data" :user="u" />
    </div>
    <Empty :show="IsEmpty||data==null" :title="type == 'followees'
        ?
        'Message.Pages.Users.NotFollowingAnyUsersYet'
        :
        (
          type == 'followers'
            ?
            'Message.Pages.Users.NotFollowedYet'
            :
            'Message.Pages.Users.NotRecommendedYet'
        )
      " :description="type == 'followees'
      ?
      'Message.Pages.Users.AfterFollowingTheUserTheCorrespondingUserWillBeDisplayedHere'
      :
      (
        type == 'followers'
          ?
          'Message.Pages.Users.AfterBeingFollowedTheCorrespondingUserWillBeDisplayedHere'
          :
          'Message.Pages.Users.RecommendedUsersWillBeDisplayedHere'
      )
    " :action_text="type == 'followees'
      ?
      'Message.Pages.Users.ViewRecommendedUsers'
      : ''
    " :action_show="type == 'followees'"
      @OnClick="() => { this.$router.push(`${this.$G_UrlHeaderLang()}/users#recommended`) }" />

    <Loading v-if="!IsEmpty" :loading="IsLoading" :pagination="pagination"
      @OnElementEntryViewport="OnElementEntryViewport" />
  </div>
</template>
<script>
import UserItem from '../../components/item/index.vue'
import Loading from '@/components/loading/index.vue'
import Empty from '@/components/empty/index.vue'
export default {
  name: 'page-users-contexts',
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
      default: 'recommended',//followees,followers,recommended
    },
  },
  components: {
    UserItem,
    Loading,
    Empty,
  },
  data() {
    return {
      IsLoading: false,
      IsEmpty: false,
      data: null,
      pagination: {
        page: 0,
        per_page: 20,
        total: 0,
        pages: 0,
        previous: 0,
        next: 1
      },
    }
  },
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
        this.GetUsers()
      }
    },
    GetUsers() {
      var token = this.$store.getters.App.UserToken || localStorage.getItem('token') || this.$cookies.get('token') || ''
      this.$axios.post('/api/users/get', {
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