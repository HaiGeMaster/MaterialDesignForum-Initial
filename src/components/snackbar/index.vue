<template>
  <v-snackbar v-model="$store.getters.App.Snackbar.Show"
  >
    {{ $store.getters.App.Snackbar.Text }}
    <template v-slot:action="{ attrs }">
      <v-btn color="pink" text v-bind="attrs" @click="$store.getters.App.Snackbar.Show = false">
        关闭
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  // props:{
  //   show: {
  //     type: Boolean,
  //     default: false
  //   },
  //   text: {
  //     type: String,
  //     default: "Message.Components.Account.Register"
  //   },
  //   OnClick: {
  //     type: Function,
  //     default: () => {}
  //   },
  // },
}
</script>