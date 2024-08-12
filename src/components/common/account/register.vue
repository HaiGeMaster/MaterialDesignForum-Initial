<template>
  <!-- <v-dialog v-model="$store.getters.App.Dialog.Register" max-width="448px" key="Register-Dialog">
    <v-card :class="[
      'mc-account mc-register glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]">
      <Title text="Message.Components.Account.Register"
      @OnDialogTitleCloseClick="$store.getters.App.Dialog.Register=false"
      />
      <v-form ref="form">
        <FieldEMail
        :show="!NextStep"
        key="Register-FieldEMail"
        label="Message.Components.Account.EMail"
        @input="(val)=>{EMail=val}"
        />
        <FieldPassword
        :show="!NextStep"
        key="Register-Password"
        label="Message.Components.Account.Password"
        @input="(val)=>{Password=val}"
        />
        <FieldEmailCode :show="!NextStep" :email="EMail" @input="(val)=>{EmailCode=val}" />
        <FieldName v-if="NextStep"
        key="Register-FieldName"
        label="Message.Components.Account.UserName"
        @input="(val)=>{UserName=val}"
        />
        <div class="actions">
          <v-checkbox
            v-model="UserServer"
            label="同意用户服务协议与隐私政策"
          ></v-checkbox>
          <v-checkbox
            v-model="CookieServer"
            label="Cookie技术来为广告商收集用户信息与维持帐号登录状态"
          ></v-checkbox>
          <FieldMore :items="FieldMoreItems" :show="!NextStep" @OnMoreListClick="OnMoreListClick"/>
          <Submit text="Message.Components.Account.NextStep" :show="!NextStep" @OnSubmitClick="OnNextStep"/>
          <Submit text="Message.Components.Account.BackStep" :show="NextStep" classes="more-option" :is_text="true" @OnSubmitClick="NextStep=!NextStep"/>
          <Submit text="Message.Components.Account.Register" :show="NextStep" @OnSubmitClick="OnSubmit" :loading="loading"/>
        </div>
      </v-form>
    </v-card>
  </v-dialog> -->
  <v-dialog v-model="$store.getters.App.Dialog.Register" scrollable max-width="380px">
    <v-card :rounded="$store.getters.App.Style.rounded" class="glass-container">
      <v-card-title class="text-h5">{{ $t('Message.Components.Account.Register') }}</v-card-title>
      <v-card-text>
        <v-form ref="form">
          <FieldEMail
            :show="!NextStep"
            key="Register-FieldEMail"
            label="Message.Components.Account.EMail"
            @input="(val)=>{EMail=val}"
            />
            <FieldPassword
            :show="!NextStep"
            key="Register-Password"
            label="Message.Components.Account.Password"
            @input="(val)=>{Password=val}"
            />
            <FieldEmailCode :show="!NextStep" :email="EMail" @input="(val)=>{EmailCode=val}" />
            <FieldName v-if="NextStep"
            key="Register-FieldName"
            label="Message.Components.Account.UserName"
            @input="(val)=>{UserName=val}"
          />
          <Submit text="Message.Components.Account.NextStep" :show="!NextStep" colors="secondary" @OnSubmitClick="OnNextStep"/>
          <Submit text="Message.Components.Account.BackStep" :show="NextStep" classes="more-option" :is_text="true" colors="secondary" @OnSubmitClick="NextStep=!NextStep"/>
          <Submit text="Message.Components.Account.Register" :show="NextStep" colors="secondary" @OnSubmitClick="OnSubmit" :loading="loading"/>
          <br />
          <FieldMore :items="FieldMoreItems" :show="!NextStep" @OnMoreListClick="OnMoreListClick"/>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import Title from '@/components/common/account/components/title.vue'
import FieldName from '@/components/common/account/components/field-name.vue'
import FieldEMail from '@/components/common/account/components/field-email.vue'
import FieldPassword from '@/components/common/account/components/field-password.vue'
import FieldEmailCode from '@/components/common/account/components/field-email-code.vue'
import FieldMore from '@/components/common/account/components/field-more.vue'
import Submit from '@/components/common/account/components/submit.vue'
export default {
  name: "register-dialog",
  data: () => ({
    loading: false,
    NextStep: false,
    EMail: "",
    UserName: "",
    Password: "",
    EmailCode: "",
    FieldMoreItems: [
      {
        text: "Message.Components.Account.ForgetPassword",
        value: "ForgetPassword"
      },
      {
        text: "Message.Components.Account.Login",
        value: "Login"
      }
    ],
    UserServer:1,
    CookieServer:false,
  }),
  components: {
    Title,
    FieldName,
    FieldEMail,
    FieldPassword,
    FieldEmailCode,
    FieldMore,
    Submit,
  },
  methods:{
    OnMoreListClick(value){
      this.$store.getters.App.Dialog.Register=false
      switch(value){
        case "ForgetPassword":
          this.$store.getters.App.Dialog.Reset=true
          break;
        case "Login":
          this.$store.getters.App.Dialog.Login=true
          break;
      }
    },
    validate() {
      return this.$refs.form.validate()
    },
    OnNextStep(){
      // if(!this.UserServer||!this.CookieServer){
      //   this.$G_SAlert(this.$t('Message.Components.Account.CannotBeEmpty'))
      //   return
      // }
      if(!this.validate()){
        return
      }
      this.NextStep = true
    },
    OnSubmit(){
      console.log(this.EMail,this.Password,this.EmailCode)
      if(!this.validate()||this.EmailCode==""){
        return
      }
      var selfs = this
      this.loading = true
      this.$axios.post('/api/user/register',
      {
        email: btoa(this.EMail),
        password: btoa(this.Password),
        email_captcha: btoa(this.EmailCode),
        username: btoa(this.UserName),
      }
      ).then(response => {
        // 处理请求成功的响应
        if(response.data.is_add==true){
          this.$G_SAlert(this.$t('Message.Components.Account.RegisterSuccess'))
          this.$store.getters.App.Dialog.Register=false
        }else{
          this.$G_SAlert(this.$t('Message.Components.Account.TheUsernameCanOnlyBeUniqueOrTheEmailHasBeenRegisteredOrTheVerificationCodeIsIncorrect'))
        }
        this.loading = false
        //console.log(response.data);
      }).catch(error => {
        this.loading = false
        // 处理请求失败的错误
        //console.error(error);
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    },
  },
  watch:{
    UserServer(val){
      console.log(val)
    },
  }
}
</script>
<style lang="less">
// @import "./index.less";
// .mc-register {
//   .dialog-title {
//     background-color: #4caf50;
//   }
// }
</style>