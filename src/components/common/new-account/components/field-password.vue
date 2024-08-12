<template>
  <v-text-field
  v-show="show"
  :label="$t(label)"
  :required="required"
  :append-icon="showt ? 'mdi-eye' : 'mdi-eye-off'"
  @click:append="showt = !showt"
  :type="showt ? 'text' : 'password'"
  :rules="[
    v => !!v || $t('Message.Components.Account.CannotBeEmpty'),
    v => (v || '').length <= 30 || $t('Message.Components.Account.MaxLengthExceeded')
  ]"
  v-model="value"
  >
  </v-text-field>
</template>
<script>
export default {
  name: "common-account-field-password",
  props:{
    label: {
      type: String,
      default: "Message.Components.Account.Password"
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
    showt: false,
  }),
  watch: {
    value: function (val) {
      // console.log(val);
      this.$emit("input", val);
    }
  }
}
</script>
<style></style>
