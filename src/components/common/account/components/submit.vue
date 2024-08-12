<template>
  <v-btn v-show="show" :class="classes" :color="colors" :text="is_text" :loading="loading" 
  block rounded x-large elevation="0" @click="$emit('OnSubmitClick')">{{ $t(text) }}</v-btn>
</template>
<script>
export default {
  name: "common-account-dialog-action-btn",
  props:{
    text: {
      type: String,
      default: "Message.Components.Account.Login"
    },
    colors: {
      type: String,
      default: "primary"
    },
    is_text: {
      type: Boolean,
      default: false
    },
    classes: {
      type: String,
      default: "action-btn"
    },
    show: {
      type: Boolean,
      default: true
    },
    loading: {
      type: Boolean,
      default: false
    },
  }
}
</script>