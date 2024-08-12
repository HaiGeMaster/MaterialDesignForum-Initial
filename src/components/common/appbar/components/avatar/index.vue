<template>
  <v-menu :close-on-content-click="false" :nudge-width="330" offset-y :rounded="$store.getters.App.Style.rounded">
    <template v-slot:activator="{ on, attrs }">
      <v-avatar size="32" v-bind="attrs" v-on="on">
        <img :src="`${$G_AvatarHandle($store.getters.App.User.avatar, 64)}`
          " width="32" height="32" />
      </v-avatar>
    </template>
    <v-card>
      <v-list-item>
        <v-list-item-avatar width="86" height="86" id="avatar-item" >
          <img :src="`${$G_AvatarHandle($store.getters.App.User.avatar, 256)}`" 
          @click="OnAvatarClick"
          />
          <!-- <AvatarUpload :avatar="$store.getters.App.User.avatar" /> -->
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>
            {{ $store.getters.App.User.username }}
            <!-- <v-badge bordered color="amber" icon="mdi-diamond-stone" overlap offset-x="-5" offset-y="16">
                  {{ $store.getters.App.User.username }}
                </v-badge> -->
          </v-list-item-title>
          <v-list-item-subtitle>
            {{
              `${$t('Message.Components.Common.Appbar.Avatar.UserID')}${$store.getters.App.User.user_id}`
            }}
            <br />
            {{
              `${$t('Message.Components.Common.Appbar.Avatar.Mailbox')}${$store.getters.App.User.email}`
            }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
          <v-btn class="ma-2" outlined color="primary"
            :to="`${$G_UrlHeaderLang()}/users/${$store.getters.App.User.user_id}`">
            {{ $t('Message.Components.Common.Appbar.Avatar.PersonalData') }}
          </v-btn>
        </v-list-item-action>
      </v-list-item>
      <v-divider></v-divider>
      <v-card-actions :color="$vuetify.theme.dark ? 'layout-dark-color-3' : 'grey lighten-5'">
        <v-btn text color="primary" v-if="$store.getters.App.User.UserGroup.ability_admin_login" @click="OnAdminOrUser">
          {{ $store.getters.App.Interface == 'admin'?$t('Message.Components.Common.Appbar.Avatar.UserPanel'):$t('Message.Components.Common.Appbar.Avatar.ManagementPanel') }}
        </v-btn>
        <ThemeButton :show="$vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm'" />
        <LanguageButton :show="$vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm'" />
        <DeviceTypeButton :show="$vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm'" />
        <v-spacer></v-spacer>
        <v-btn color="primary" text outlined @click="OnLogout">
          {{ $t('Message.Components.Common.Appbar.Avatar.Logout') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-menu>
</template>
<script>
import ThemeButton from '@/components/common/appbar/components/theme-button/index.vue'
import LanguageButton from '@/components/common/appbar/components/language-button/index.vue'
import DeviceTypeButton from '@/components/common/appbar/components/device-type-button/index.vue'
import AvatarUpload from '@/components/avatar-upload/index.vue'
export default {
  name: 'avatar',
  components: {
    ThemeButton,
    LanguageButton,
    DeviceTypeButton,
    AvatarUpload,
  },
  data: () => ({
  }),
  created() {
  },
  methods: {
    OnLogout() {
      this.$store.getters.App.IsLogin = false
      localStorage.removeItem('token')
      this.$cookies.remove('token')
    },
    OnAdminOrUser() {
      if (this.$store.getters.App.User.UserGroup.ability_admin_login && this.$store.getters.App.Interface == 'user') {
        this.$store.getters.App.Interface = 'admin'
      } else {
        this.$store.getters.App.Interface = 'user'
      }
      //console.log(this.$store.getters.App.Interface)
    },
    OnAvatarClick(){
      if(this.$route.path != `${this.$G_UrlHeaderLang()}/users/${this.$store.getters.App.User.user_id}`){
        this.$router.push({
          path: `${this.$G_UrlHeaderLang()}/users/${this.$store.getters.App.User.user_id}`,
        })
      }
    }
  },
  watch: {
    '$store.getters.App.Interface'(val) {
      //console.log(val)
      if (val == 'admin') {
        if (this.$store.getters.App.User.UserGroup.ability_admin_login) {
          if(this.$route.path != `${this.$G_UrlHeaderLang()}/admin`){
            this.$router.push({
              path: `${this.$G_UrlHeaderLang()}/admin`,
            })
          }
        } else {
          this.$store.getters.App.Interface = 'user'
          if(this.$route.path != `${this.$G_UrlHeaderLang()}/`){
            this.$router.push({
              path: `${this.$G_UrlHeaderLang()}/`,
            })
          }
        }
      }else{
        this.$store.getters.App.Interface = 'user'
        if(this.$route.path != `${this.$G_UrlHeaderLang()}/`){
          this.$router.push({
            path: `${this.$G_UrlHeaderLang()}/`,
          })
        }
      }
      this.$forceUpdate()
    }
  }
}
</script>
<style lang="less">
#avatar-item {
  .mc-avatar-upload {
    display: none;
  }

  &:hover .mc-avatar-upload {
    display: block;
  }

  .upload-btn {
    display: block;
    width: 48px;
    min-width: 48px;
    height: 48px;
    background-color: rgba(0, 0, 0, .26) !important;
  }
}
</style>