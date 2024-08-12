<template>
  <v-menu offset-y top :rounded="$store.getters.App.Style.rounded">
    <template v-slot:activator="{ attrs, on }">
      <v-btn icon
      @click.stop.prevent="action"
      v-bind="attrs" v-on="on" color="grey darken-1">
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </template>
    <v-list>
      <v-list-item link>
        <v-list-item-title>{{ $t('Message.Pages.Topic.Topic.CopyLink') }}</v-list-item-title>
      </v-list-item>
      <v-list-item link>
        <v-list-item-title>{{ $t('Message.Pages.Topic.Topic.Share') }}</v-list-item-title>
      </v-list-item>
      <v-list-item link>
        <v-list-item-title>{{
          $t('Message.Pages.Topic.Topic.LookFollowers').replace('%s', '0')
        }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>
<script>
export default{
  name: 'options-button',
  props:{
    type: {
      type: String,
      default: 'topic',
    },
    id:{
      type: Number,
      default: 0,
    },
    action: {
      type: Function,
      default: () => {},
    },
  },
}
</script>
<style></style>