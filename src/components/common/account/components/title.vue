<template>
  <div class="dialog-title" v-show="show">
    <v-btn icon class="close" @click="$emit('OnDialogTitleCloseClick')">
      <v-icon color="white">{{ icon }}</v-icon>
    </v-btn>
    {{ $t(text) }}
  </div>
</template>
<script>
export default {
  name: "common-account-dialog-title",
  props:{
    text: {
      type: String,
      default: "Message.Components.Account.Login"
    },
    icon: {
      type: String,
      default: "mdi-close"
    },
    mode_class: {
      type: String,
      default: "login"
    },
    show: {
      type: Boolean,
      default: true
    },
  }
}
</script>