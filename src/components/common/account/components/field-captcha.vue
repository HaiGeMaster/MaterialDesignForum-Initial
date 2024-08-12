<template>
  <div class="captcha-field" v-show="show">
    <v-text-field :label="$t(label)" :required="required" type="text" filled
    :loading="loading"
    :rules="[
      v => !!v || $t('Message.Components.Account.CannotBeEmpty'),
      v => (v || '').length <= 6 || $t('Message.Components.Account.MaxLengthExceeded')
    ]" v-model="value">
      <template v-slot:append-outer>
        <img class="captcha-image" :src="`${$G_ImgHandle('/api/user/image_captcha/')}${img_time}`" @click="OnImgClick" :title="$t('Message.Components.Account.RefreshImageCode')" />
      </template>
    </v-text-field>
  </div>
</template>
<script>
export default {
  name: "common-account-field-captcha",
  props:{
    label: {
      type: String,
      default: "Message.Components.Account.ImageCode"
    },
    required: {
      type: Boolean,
      default: true
    },
    show: {
      type: Boolean,
      default: true
    },
  },
  data: () => ({
    value: "",
    img_time:0,
    img: "",
    loading:false,
  }),
  methods:{
    async OnImgClick(){
      this.img_time = new Date().getTime()
      this.loading = true
      setTimeout(() => {
        this.loading = false
      }, 5000);
    },
  },
  watch: {
    value: function (val) {
      this.$emit("input", val);
    }
  }
}
</script>
<style></style>