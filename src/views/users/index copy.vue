<template>
  <v-container id="page-users"
    :style="`max-width: 1084px;${$vuetify.breakpoint.name != 'xs' ? 'padding-top: 12px;' : 'padding-top: 0px;'}`">
    <v-subheader class="subheading" key="page-users-subheader" style="margin-top: 4px;">{{
      switchState
    }}</v-subheader>
    <div class="items-wrapper">

      <div id="followees" v-if="ItemShowPage == 'followees'">
        <UserItem v-for="u in followeesData" v-if="$G_IsVaild(followeesData)" :user="u" />
      </div>


      <div id="followers" v-if="ItemShowPage == 'followers'">
        <UserItem v-for="u in followersData" v-if="$G_IsVaild(followersData)" :user="u" />
      </div>


      <div id="recommended" v-if="ItemShowPage == 'recommended'">
        <UserItem v-for="u in recommendedData" v-if="$G_IsVaild(recommendedData)" :user="u" />
      </div>

    </div>
    <Loading
    :loading="IsLoading" 
    :pagination="
      ItemShowPage == 'followees' ? followeesData_pagination : 
      ItemShowPage == 'followers' ? followersData_pagination : 
      ItemShowPage == 'recommended' ? recommendedData_pagination : null
    " 
    @OnElementEntryViewport="OnElementEntryViewport" />
  </v-container>
</template>
<script>
import UserItem from './components/item/index.vue'
import Loading from '@/components/loading/index.vue'
export default {
  name: 'page-users',
  components: {
    UserItem,
    Loading,
  },
  data: () => ({
    subheader: "Message.Pages.Users.FolloweesHeaderTitle",
    ItemShowPage: '',
    IsLoading: false,
    followeesData: null,
    followersData: null,
    recommendedData: null,
    followeesData_pagination: {
      page: 0,
      per_page: 20,
      total: null,
      pages: null,
      previous: null,
      next: 1
    },
    followersData_pagination: {
      page: 0,
      per_page: 20,
      total: null,
      pages: null,
      previous: null,
      next: 1
    },
    recommendedData_pagination: {
      page: 0,
      per_page: 20,
      total: null,
      pages: null,
      previous: null,
      next: 1
    },
  }),
  computed: {
    switchState() {
      if (!this.$store.getters.App.IsLogin) {
        return this.$t("Message.Pages.Users.RecommendedHeaderTitle")
      } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#followers' && this.followersData) {
        var a = this.$t("Message.Pages.Users.FollowersHeaderTitle")
        return a.replace("%s", this.followersData.length)
      } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#recommended' && this.recommendedData) {
        return this.$t("Message.Pages.Users.RecommendedHeaderTitle")
      } else if (this.$store.getters.App.IsLogin && (this.$route.hash == '#followees' || this.$route.hash == '') && this.followeesData) {
        var a = this.$t("Message.Pages.Users.FolloweesHeaderTitle")
        return a.replace("%s", this.followeesData.length)
      }
    },
    
  },
  methods: {
    ItemShowPages() {
      var a = ''
      if (this.$store.getters.App.IsLogin && this.$route.hash == '#followers') {
        a = 'followers'
      } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#followees') {
        a = 'followees'
      } else if (this.$store.getters.App.IsLogin && (this.$route.hash == '#recommended' || this.$route.hash == '')) {
        a = 'recommended'
      } else if (!this.$store.getters.App.IsLogin) {
        a = 'recommended'
      }
      console.log(a)
      return a
    },
    SwitchWebTitle(to) {
      if (to.path == `${this.$G_UrlHeaderLang()}/users`) {
        this.$G_SetWebSubTitle('Message.Pages.Users.WebSubTitle', true)
        if ((to.hash == '#followees' || to.hash == '') && this.$store.getters.App.IsLogin) {
          this.$G_SetWebSubTitle('Message.Pages.Users.PeopleIFollow')
        } else if (to.hash == '#followers' && this.$store.getters.App.IsLogin) {
          this.$G_SetWebSubTitle('Message.Pages.Users.MyFollowers')
        } else if ((this.$store.getters.App.IsLogin && to.hash == '#recommended') || (!this.$store.getters.App.IsLogin && to.hash == '')) {
          this.$G_SetWebSubTitle('Message.Pages.Users.RecommendedContacts')
        }
      }
    },
    OnElementEntryViewport(isEntry) {
      
      if(this.$route.path != `${this.$G_UrlHeaderLang()}/users`){//如果不是在用户页面则不执行
        //console.log('OnElementEntryViewport:return')
        return
      }
      //console.log('OnElementEntryViewport:'+isEntry)
      if (isEntry) {
        this.IsLoading = true
        this.GetUsers()
      }
    },
    GetUsers() {
      var page = 0
      var next = null
      switch (this.ItemShowPage) {
        case 'followees':
          page = this.followeesData_pagination.page
          next = this.followeesData_pagination.next
          break;
        case 'followers':
          page = this.followersData_pagination.page
          next = this.followersData_pagination.next
          break;
        case 'recommended':
          page = this.recommendedData_pagination.page
          next = this.recommendedData_pagination.next
          break;
        default:
          break;
      }
      if (next == null||next == 0) {
        this.IsLoading = false
        return
      }
      this.$axios.get(`/api/users/${this.ItemShowPage}/${next}`
      ).then(response => {
        if(response.data.is_get==true){
          this.IsLoading = false
          switch (this.ItemShowPage) {
            case 'followees':
              this.followeesData==null?this.followeesData=response.data.data:response.data.data.forEach((item,index)=>{
                //如果item.user_id在this.followeesData中存在则不添加
                var index = this.followeesData.findIndex(item2 => item2.user_id === item.user_id);
                // 如果找到相同的项，isExist 为 true
                var isExist = index !== -1;
                if(!isExist){
                  this.followeesData.push(item)
                }
              })
              this.followeesData_pagination = response.data.pagination
              console.log(this.followeesData)
              console.log(this.followeesData_pagination)
              break;
            case 'followers':
              this.followersData==null?this.followersData=response.data.data:response.data.data.forEach((item,index)=>{
                //如果item.user_id在this.followersData中存在则不添加
                var index = this.followersData.findIndex(item2 => item2.user_id === item.user_id);
                // 如果找到相同的项，isExist 为 true
                var isExist = index !== -1;
                if(!isExist){
                  this.followersData.push(item)
                }
              })
              this.followersData_pagination = response.data.pagination
              console.log(this.followersData)
              console.log(this.followersData_pagination)
              break;
            case 'recommended':
              this.recommendedData==null?this.recommendedData=response.data.data:response.data.data.forEach((item,index)=>{
                //如果item.user_id在this.recommendedData中存在则不添加
                var index = this.recommendedData.findIndex(item2 => item2.user_id === item.user_id);
                // 如果找到相同的项，isExist 为 true
                var isExist = index !== -1;
                if(!isExist){
                  this.recommendedData.push(item)
                }
              })
              this.recommendedData_pagination = response.data.pagination
              console.log(this.recommendedData)
              console.log(this.recommendedData_pagination)
              break;
            default:
              break;
          }
          this.$forceUpdate()
        }else{
          this.IsLoading = false
          //this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
        }
      }).catch(err => {
        this.IsLoading = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      })
    },
  },
  watch: {
    '$route'(to, from) {
      this.SwitchWebTitle(to)
      this.OnElementEntryViewport(true)
      this.ItemShowPage = this.ItemShowPages()
    },
    '$store.getters.App.IsLogin'(val, oldVal) {
      if (val != oldVal) {
        this.OnElementEntryViewport(true)
      }
    },
    followeesData: {
      handler(val, oldVal) {
        if (val != null) {
          this.$G_AddOnScrollBottomCallback(`${this.$G_UrlHeaderLang()}/users`, '#followees', () => {
            this.GetUsers()
          })
        }
      },
      deep: true
    },
    followersData: {
      handler(val, oldVal) {
        if (val != null) {
          this.$G_AddOnScrollBottomCallback(`${this.$G_UrlHeaderLang()}/users`, '#followers', () => {
            this.GetUsers()
          })
        }
      },
      deep: true
    },
    recommendedData: {
      handler(val, oldVal) {
        if (val != null) {
          this.$G_AddOnScrollBottomCallback(`${this.$G_UrlHeaderLang()}/users`, '#recommended', () => {
            this.GetUsers()
          })
        }
      },
      deep: true
    },
  },
  mounted() {
    this.SwitchWebTitle(this.$route)
    //this.OnElementEntryViewport(true)
  },
  created() {
    //this.OnElementEntryViewport(true)
  }
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
}
</style>