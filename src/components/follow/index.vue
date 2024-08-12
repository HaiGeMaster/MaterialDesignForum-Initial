<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-btn icon outlined fab small class="mc-follow" :color="$vuetify.theme.dark ? 'grey darken-3' : 'grey lighten-1'"
        v-bind="attrs" v-on="on"
        @click.stop.prevent="OnFollowClickCallback()"
        :loading="IsLoading"
        >
        <v-icon
        :color="
        IsFollow?'primary':'grey darken-1'
        "
        >{{IsFollow?'mdi-star':'mdi-star-outline'}}</v-icon>
      </v-btn>
    </template>
    <span>{{ IsFollow?$t('Message.Components.Follow.Unfollow'):$t('Message.Components.Follow.Follow') }}</span>
  </v-tooltip>
</template>
<script>
export default {
  name:'follow',
  props:{
    followable_type: String,
    followable_id: Number,
    is_follow: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    IsFollow: false,
    IsLoading: false,
  }),
  created() {
    this.IsFollow = this.is_follow
  },
  methods:{
    OnFollowClickCallback(){
      if(this.$store.getters.App.IsLogin == false){
        //this.$G_SAlert(this.$t('Message.Components.Account.NotLogin'))
        this.$store.getters.App.Dialog.Login = true
        return
      }

      //this.IsFollow = !this.IsFollow
      var token = this.$store.getters.App.UserToken
      var followable_type = this.followable_type
      var followable_id = this.followable_id
      this.IsLoading = true
      this.$axios.post('/api/user/follow',{
        user_token: token,
        followable_type: followable_type,
        followable_id: followable_id,
      })
      .then(res=>{
        if(res.data.is_follow == true){
          this.IsFollow = true
        }else{
          this.IsFollow = false
        }
        this.IsLoading = false
      })
      .catch(err=>{
        this.IsLoading = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    }
  }
}
</script>
<style lang="less">
.mc-follow {
  i {
    font-size: 21px !important;
  }
}
</style>