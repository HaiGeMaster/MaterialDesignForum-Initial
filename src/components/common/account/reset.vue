<template>
  <!-- <v-dialog v-model="$store.getters.App.Dialog.Reset" max-width="448px" key="Reset-Dialog">
    <v-card :class="[
      'mc-account mc-reset glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]">
      <Title text="Message.Components.Account.ForgetPassword"
      @OnDialogTitleCloseClick="$store.getters.App.Dialog.Reset=false"
      />
      <v-form ref="form">
        <FieldEMail
        :show="!NextStep"
        key="Reset-FieldEMail"
        @input="(val)=>{EMail=val}"
        />
        <FieldEmailCode 
        :email="EMail"
        :show="!NextStep"
        key="Reset-FieldEmailCode"
        @input="(val)=>{EmailCode=val}"/>
        <FieldPassword 
        v-if="NextStep"
        key="Reset-FieldPassword"
        @input="(val)=>{Password=val}"/>
        <div class="actions">
          <FieldMore :items="FieldMoreItems" :show="!NextStep" @OnMoreListClick="OnMoreListClick"/>
          <Submit text="Message.Components.Account.NextStep" :show="!NextStep" @OnSubmitClick="OnNextStep"/>
          <Submit text="Message.Components.Account.BackStep" :show="NextStep" classes="more-option" :is_text="true" @OnSubmitClick="NextStep=!NextStep"/>
          <Submit text="Message.Components.Account.Reset" :show="NextStep" @OnSubmitClick="OnSubmit" :loading="loading"/>
        </div>
      </v-form>
    </v-card>
  </v-dialog> -->
  <v-dialog v-model="$store.getters.App.Dialog.Reset" scrollable max-width="380px">
    <v-card :rounded="$store.getters.App.Style.rounded" class="glass-container">
      <v-card-title class="text-h5">{{ $t('Message.Components.Account.ForgetPassword') }}</v-card-title>
      <v-card-text>
        <v-form ref="form">
          <FieldEMail :show="!NextStep" key="Reset-FieldEMail" @input="(val) => { EMail = val }" />
          <FieldEmailCode :email="EMail" :show="!NextStep" key="Reset-FieldEmailCode" @input="(val) => { EmailCode = val }" />
          <FieldPassword v-if="NextStep" key="Reset-FieldPassword" @input="(val) => { Password = val }" />
          <Submit text="Message.Components.Account.NextStep" :show="!NextStep" colors="accent" @OnSubmitClick="OnNextStep" />
          <Submit text="Message.Components.Account.BackStep" :show="NextStep" classes="more-option" :is_text="true"
          colors="accent" @OnSubmitClick="NextStep = !NextStep" />
          <Submit text="Message.Components.Account.Reset" :show="NextStep" colors="accent" @OnSubmitClick="OnSubmit" :loading="loading" />
          <br />
          <FieldMore :items="FieldMoreItems" :show="!NextStep" @OnMoreListClick="OnMoreListClick" />
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import Title from '@/components/common/account/components/title.vue'
import FieldEMail from '@/components/common/account/components/field-email.vue'
import FieldEmailCode from '@/components/common/account/components/field-email-code.vue'
import FieldPassword from '@/components/common/account/components/field-password.vue'
import FieldMore from '@/components/common/account/components/field-more.vue'
import Submit from '@/components/common/account/components/submit.vue'
export default {
  name: "reset-dialog",
  data: () => ({
    loading: false,
    EMail: "",
    Password: "",
    EmailCode: "",
    NextStep: false,
    FieldMoreItems: [
      {
        text: "Message.Components.Account.Login",
        value: "Login"
      },
      {
        text: "Message.Components.Account.Register",
        value: "Register"
      }
    ]
  }),
  components: {
    Title,
    FieldEMail,
    FieldEmailCode,
    FieldPassword,
    FieldMore,
    Submit,
  },
  methods: {
    OnMoreListClick(value) {
      this.$store.getters.App.Dialog.Reset = false
      switch (value) {
        case "Login":
          this.$store.getters.App.Dialog.Login = true
          break;
        case "Register":
          this.$store.getters.App.Dialog.Register = true
          break;
      }
    },
    OnNextStep() {
      console.log(this.validate())
      if (!this.validate()) {
        return
      }
      this.NextStep = true
    },
    OnSubmit() {
      if (!this.validate()) {
        return
      }
      var selfs = this
      this.loading = true
      this.$axios.post('/api/user/reset',
        {
          email: btoa(this.EMail),
          password: btoa(this.Password),
          email_captcha: btoa(this.EmailCode),
        }
      ).then(response => {
        // 处理请求成功的响应
        //console.log(response);
        if (response.data.is_reset == true) {
          this.$G_SAlert(this.$t('Message.Components.Account.ResetSuccess'))
          this.$store.getters.App.Dialog.Reset = false
        } else {
          this.$G_SAlert(this.$t('Message.Components.Account.TheResetEmailDoesNotExistOrTheVerificationCodeIsIncorrect'))
        }
        this.loading = false
      }).catch(error => {
        this.loading = false
        // 处理请求失败的错误
        //console.error(error);
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    },
    validate() {
      return this.$refs.form.validate()
    },
  }
}
</script>
<style lang="less">
// @import "./index.less";

// .mc-reset {
//   .dialog-title {
//     background-color: #ff5722;
//   }
// }
</style>