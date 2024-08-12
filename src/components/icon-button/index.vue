<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-btn icon outlined fab small :color="$vuetify.theme.dark ? 'grey darken-3' : 'grey lighten-1'"
        v-bind="attrs" v-on="on"
        @click.stop.prevent="$emit('OnIconButtonClick')"
        style="margin-left: 4px;margin-right: 4px;"
        >
        <v-icon color="grey darken-1" :small="smalls">{{icon}}</v-icon>
      </v-btn>
    </template>
    <span>{{ $t(text) }}</span>
  </v-tooltip>
</template>
<script>
export default {
  name:'icon-button',
  props:{
    icon:String,
    text:String,
    smalls:{
      type:Boolean,
      default:true
    },
  },
}
</script>
<style lang="less">
</style>