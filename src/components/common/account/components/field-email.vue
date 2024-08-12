<template>
  <v-text-field :label="$t(label)" :required="required" v-show="show" filled
  :rules="[
    v => !!v || $t('Message.Components.Account.CannotBeEmpty'),
    v => /^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/.test(v) || $t('Message.Components.Account.EMailError'),
    v => (v || '').length <= 100 || $t('Message.Components.Account.MaxLengthExceeded')
  ]"
  v-model="value">
  </v-text-field>
</template>
<script>
export default {
  name: "common-account-field-email",
  props:{
    label: {
      type: String,
      default: "Message.Components.Account.EMail"
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
  }),
  watch: {
    value: function (val) {
      this.$emit("input", val);
    }
  }
}
</script>
<style></style>