<template>
  <div class="send-email-field" v-show="show">
    <v-text-field :label="$t(label)" :required="required" type="text" filled
    class="captcha-field"
    :rules="[
      v => !!v || $t('Message.Components.Account.CannotBeEmpty'),
      v => (v || '').length <= 6 || $t('Message.Components.Account.MaxLengthExceeded')
    ]" v-model="value">
    <template v-slot:append-outer>
      <v-btn :loading="loading" class="send-email" text @click="OnSendEmailClick()">
        {{ $t('Message.Components.Account.SendEMailCode') }}
        <template v-slot:loader>
          <span>{{ loading_time }}</span>
        </template>
      </v-btn>
    </template>
    </v-text-field>
  </div>
</template>
<script>
export default {
  name: "common-account-field-email-code",
  props:{
    label: {
      type: String,
      default: "Message.Components.Account.EMailCode"
    },
    required: {
      type: Boolean,
      default: true
    },
    show: {
      type: Boolean,
      default: true
    },
    email: {
      type: String,
      default: ""
    },
    // loading: {
    //   type: Boolean,
    //   default: false
    // }
  },
  data: () => ({
    value: "",
    show_resend_countdown: false,
    loading:false,
    loading_time:0,
    //loading: false,
  }),
  methods:{
    OnSendEmailClick(){
      this.loading = true
      this.loading_time = 60

      var selfs = this
      //console.log(btoa(this.email))
      this.$axios.post('/api/user/email_captcha',{
         email: btoa(this.email),
         lang: btoa(this.$i18n.locale)
      }
      ).then(response => {
        // 处理请求成功的响应
        //console.log(response);
        if(response.data.is_send==true){
          
          this.$G_SAlert(this.$t('Message.Components.Account.SendEMailCodeSuccess'))
        }else{
          this.loading = false
          this.loading_time = 0
          this.$G_SAlert(this.$t('Message.Components.Account.SendEMailCodeFail'))
        }
      }).catch(error => {
        this.loading = false
        this.loading_time = 0
        // 处理请求失败的错误
        //console.error(error);
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    }
  },
  watch: {
    value: function (val) {
      this.$emit("input", val);
    },
    loading_time:function(val){
      if(!this.loading){
        this.loading_time = 0
        return
      }
      if(val!=0){
        if(!this.loading){
          this.loading_time = 0
          return
        }
        setTimeout(() => {
          this.loading_time = val-1
        }, 1000);
      }else{
        this.loading = false
      }
    }
  }
}
</script>
<style></style>