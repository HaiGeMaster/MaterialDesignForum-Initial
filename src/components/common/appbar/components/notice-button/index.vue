<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-btn icon v-show="show" v-bind="attrs" v-on="on">
        <v-icon>
          mdi-bell
        </v-icon>
      </v-btn>
    </template>
    <span>{{ $t('Message.Components.Common.Appbar.NoticeButton.Notice') }}</span>
  </v-tooltip>
</template>
<script>
export default {
  name: 'notice-button',
  props:{
    show: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
  },
}
</script>