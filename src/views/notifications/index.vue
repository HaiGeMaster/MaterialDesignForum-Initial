<template>
  <v-container id="page-notifications" v-if="$store.getters.App.IsLogin"
    :style="$vuetify.breakpoint.name != 'xs' ? 'max-width: 800px;padding:0 16px;' : 'max-width: 800px;padding:0 0px;'">
    <div :style="{
      'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '0px',
    }">
      <v-subheader class="subheading" key="page-notifications-subheader">
        通知
      </v-subheader>
      <div :style="{
        'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
      }">
        <div class="notifications-system" v-show="$route.hash == '' || $route.hash == '#system'">
          <MessageCard />
        </div>
        <div class="notifications-user-group" v-show="$route.hash == '#user_group'">
          <MessageCard />
        </div>
        <div class="notifications-private-message" v-show="$route.hash == '#private_message'">
          私信
        </div>
      </div>
    </div>


  </v-container>
</template>
<script>
import MessageCard from '@/components/message-card/index.vue'
export default {
  name: 'page-notifications',
  components: {
    MessageCard,
  },
  computed: {
    // switchState() {
    //   if (!this.$store.getters.App.IsLogin) {
    //     return '!this.App.IsLogin'
    //   } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#private_message') {
    //     return this.$t("Message.Pages.Topics.HeaderTitle")
    //   } else if (this.$store.getters.App.IsLogin && this.$route.hash == '#user_group') {
    //     return this.$t("Message.Pages.Topics.HeaderTitle")
    //   } else if (this.$store.getters.App.IsLogin && (this.$route.hash == '#system'||this.$route.hash == '')) {
    //     var a = this.$t("Message.Pages.Topics.FollowedNTopic")
    //     return a
    //   }
    // }
  },
  methods: {
    SwitchWebTitle(to) {
      if (to.path == `${this.$G_UrlHeaderLang()}/notifications`) {
        this.$G_SetWebSubTitle('Message.Pages.Notifications.WebSubTitle', true)
        if ((to.hash == '#system' || to.hash == '') && this.$store.getters.App.IsLogin) {
          this.$G_SetWebSubTitle('Message.Pages.Notifications.SystemNotifications')
        } else if (to.hash == '#user_group' && this.$store.getters.App.IsLogin) {
          this.$G_SetWebSubTitle('Message.Pages.Notifications.UserGroupNotifications')
        } else if (this.$store.getters.App.IsLogin && to.hash == '#private_message') {
          this.$G_SetWebSubTitle('Message.Pages.Notifications.PrivateMessageNotifications')
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
<style></style>