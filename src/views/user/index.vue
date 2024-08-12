<template>
  <v-container id="page-user"
    :style="$vuetify.breakpoint.name != 'xs' ? 'max-width: 830px;padding:0 12px;' : 'max-width: 830px;padding:0 0px;'">
    <User v-if="!IsEmpty" :user="User"/>
    <Contexts v-if="!IsEmpty" :user="User"/>
    <!-- <Loading v-if="!IsEmpty" :user="User" :loading="IsLoading"/> -->
    <NoPage v-if="IsEmpty"/>
    <!-- <EditInfoDialog/> -->
    <EditInfoDialog :user="User"/>
  </v-container>
</template>
<script>
import Contexts from './components/contexts/index.vue'
import User from './components/user/index.vue'
//import Loading from '@/components/loading/index.vue'
// import Empty from '@/components/empty/index.vue'
import EditInfoDialog from '@/components/edit-info-dialog/index.vue'
import NoPage from '@/views/404/index.vue'

export default {
  name: 'page-user',
  components: {
    Contexts,
    User,
    //Loading,
    NoPage,
    EditInfoDialog,
    //EditInfoDialog,
  },
  data: () => ({
    IsLoading: false,
    User: null,
    IsEmpty: false,
    IsMounted: false,
  }),//this.$route.params.user_id
  methods:{
    // OnUserUpdate(val){
    //   //this.$store.getters.App.User = val;
    //   // this.User = val;
    //   // this.$forceUpdate();
    //   //this.GetUserInfo()
    //   this.User = null
    //   this.User = val
    //   this.$store.getters.App.User = val
    //   //this.SwitchWebTitle(this.$route)
    //   this.$forceUpdate()
    //   this.GetUserInfo()
    // },
    SwitchWebTitle(to){
      if(this.User==null){
        return
      }
      if(to.path==`${this.$G_UrlHeaderLang()}/users/${this.$store.getters.App.User.user_id}`){
        this.$G_SetAppbarSubTitle(this.$t('Message.Pages.User.NPersonalHomepage').replace('%s',this.$store.getters.App.User.username))
        this.$G_SetWebSubTitle(this.$t('Message.Pages.User.NPersonalHomepage').replace('%s',this.$store.getters.App.User.username),false)
      }else{
        this.$G_SetAppbarSubTitle(this.User.username)
        this.$G_SetWebSubTitle(this.$t('Message.Pages.User.NPersonalHomepage').replace('%s',this.User.username),false)
      }
    },
    GetUserInfo(user_id = this.$route.params.user_id){
      if(user_id==this.$store.getters.App.User.user_id){
        this.User = this.$store.getters.App.User
        this.IsLoading = false
        this.IsEmpty = false
        this.$forceUpdate()
        this.SwitchWebTitle(this.$route)
        return
      }
      this.IsLoading = true
      //var selfs = this
      var token = this.$store.getters.App.UserToken || localStorage.getItem('token') || this.$cookies.get('token')||''
      this.$axios.post('/api/user/get/',{
        user_id: user_id,
        user_token: token!=''?token:'',
      }).then(res => {
        if(res.data.is_get){
          this.User = res.data.user
          this.IsLoading = false
          this.IsEmpty = false
          this.$forceUpdate()
          this.SwitchWebTitle(this.$route)
        }else{
          this.IsEmpty = true
          this.IsLoading = false
          this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
        }
      }).catch(err => {
        this.IsEmpty = true
        this.IsLoading = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      })
    },
  },
  watch:{
    '$route'(to, from) {
      if(to.path.indexOf(`${this.$G_UrlHeaderLang()}/users/`)!=0){
        return
      }
      
      this.SwitchWebTitle(to)
      this.GetUserInfo(to.params.user_id)
    }
  },
  mounted() {
    if(!this.IsMounted){
      this.IsMounted = true
      this.GetUserInfo()
    }
    this.SwitchWebTitle(this.$route)
  },
  created() {
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
#page-topic .contexts,
#page-user .contexts {
  margin-top: 16px;
  .mc-list-header {
    //padding: 16px;
    padding-left: 16px;
    padding-top: 8px;
    padding-bottom: 8px;
    padding-right: 16px;
    .title {
      font-size: 16px;
    }
    button {
      padding-right: 0;
    }
  }
  .v-card{
    margin-top: 0;
  }
  @media (max-width: @screen-xs-max) {
    border-right: none;
    border-left: none;
    border-radius: 0;
    .mc-list-header {
      .title {
        font-size: 15px;
      }
    }
  }
}</style>