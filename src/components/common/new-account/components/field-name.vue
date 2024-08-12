<template>
  <v-text-field
  v-show="show"
  :label="$t(label)"
  :required="required"
  type="text"
  :rules="[
    v => !!v || $t('Message.Components.Account.CannotBeEmpty'),
    v => (v || '').length <= 50 || $t('Message.Components.Account.MaxLengthExceeded')
  ]"
  v-model="value"
  >
  </v-text-field>
</template>
<script>
export default {
  name: "common-account-field-name",
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