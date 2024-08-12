<template>
  <v-dialog v-model="$store.getters.App.Dialog.Login" max-width="448px" key="Login-Dialog">
    <v-card :class="[
      'mc-account mc-login glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-' + $store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]">
      <Title text="Message.Components.Account.Login" @OnDialogTitleCloseClick="$store.getters.App.Dialog.Login = false" />
      <v-form ref="form">
        <FieldName label="Message.Components.Account.UserNameOrEMail" @input="(val) => { UserNameOrEMail = val }" />
        <FieldPassword @input="(val) => { Password = val }" />
        <FieldCaptcha v-if="ErrorCount >= 3" @input="(val) => { Captcha = val }" />
        <div class="actions">
          <FieldMore :items="FieldMoreItems" @OnMoreListClick="OnMoreListClick" />
          <Submit text="Message.Components.Account.Login" :loading="loading" @OnSubmitClick="OnSubmit" />
        </div>
      </v-form>
    </v-card>
  </v-dialog>
</template>
<script>
import Title from '@/components/common/account/components/title.vue'
import FieldName from '@/components/common/account/components/field-name.vue'
import FieldPassword from '@/components/common/account/components/field-password.vue'
import FieldCaptcha from '@/components/common/account/components/field-captcha.vue'
import FieldMore from '@/components/common/account/components/field-more.vue'
import Submit from '@/components/common/account/components/submit.vue'
export default {
  name: "login-dialog",
  data: () => ({
    UserNameOrEMail: "",
    Password: "",
    Captcha: "",
    ErrorCount: 0,
    loading: false,
    FieldMoreItems: [
      {
        text: "Message.Components.Account.ForgetPassword",
        value: "ForgetPassword"
      },
      {
        text: "Message.Components.Account.Register",
        value: "Register"
      }
    ]
  }),
  components: {
    Title,
    FieldName,
    FieldPassword,
    FieldCaptcha,
    FieldMore,
    Submit,
  },
  methods: {
    OnMoreListClick(value) {
      this.$store.getters.App.Dialog.Login = false
      switch (value) {
        case "ForgetPassword":
          this.$store.getters.App.Dialog.Reset = true
          break;
        case "Register":
          this.$store.getters.App.Dialog.Register = true
          break;
      }
    },
    validate() {
      return this.$refs.form.validate()
    },
    OnSubmit() {
      if (this.validate()) {
        this.loading = true
        this.$axios.post('/api/user/login',
          {
            emailorname: btoa(this.UserNameOrEMail),
            password: btoa(this.Password),
            captcha: this.Captcha ? btoa(this.Captcha) : '',
          }
        ).then(response => {
          console.log(this.UserNameOrEMail, this.Password, this.Captcha)
          if (response.data.is_login == true) {
            localStorage.setItem('token', response.data.token);
            this.$cookies.set('token', response.data.token, {
              path: '/',
              expires: new Date(response.data.expires),
            });
            this.$G_SAlert(this.$t('Message.Components.Account.LoginSuccess'))
            this.AutoLogin()
          } else {
            this.ErrorCount++
            this.$G_SAlert(this.$t('Message.Components.Account.LoginEmailOrUsernameDoesNotExistOrPasswordOrVerificationCodeIsIncorrect'))
          }
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
        });
      }
    },
    async AutoLogin() {
      var token = this.$cookies.get('token') || localStorage.getItem('token') || ''
      if (token != '') {
        this.$axios.post('/api/user/auto_login',
          {
            user_token: token,
          }
        ).then(response => {
          if (response.data.is_login == true) {
            this.$store.getters.App.Dialog.Login = false
            this.$store.getters.App.IsLogin = true
            this.$store.getters.App.UserToken = token
            this.$store.getters.App.User = response.data.user
            this.ErrorCount = 0
            this.Captcha = ''
            //this.$G_SAlert(this.$t('Message.Components.Account.LoginSuccess'))
          } else {
            this.$G_SAlert(this.$t('Message.Components.Account.LoginFail'))
            localStorage.removeItem('token')
            this.$cookies.remove('token')
            this.$store.getters.App.IsLogin = false
            if (this.$route.path !== `${this.$G_UrlHeaderLang()}/`) {
              this.$router.push(`${this.$G_UrlHeaderLang()}/`)
            }
          }
        }).catch(error => {
          this.$store.getters.App.IsLogin = false
          this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
        });
      }
    }
  },
  mounted() {
    this.AutoLogin()
  }
}
</script>
<style lang="less">
@import "./index.less";

.mc-login {
  .dialog-title {
    background-color: #3F51B5; //rgba(73, 82, 182,0.5)
  }
}
</style>