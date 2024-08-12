<template>
  <v-menu top :rounded="$store.getters.App.Style.rounded">
    <template v-slot:activator="{ on, attrs }">
      <v-btn v-bind="attrs" v-on="on" class="more-option" v-show="show" block rounded x-large elevation="0">
        {{ $t('Message.Components.Account.MoreOption') }}
        <!-- <v-icon>mdi-dots-vertical</v-icon> -->
      </v-btn>
    </template>
    <v-list>
      <v-list-item-group color="primary">
        <v-list-item v-for="(item, index) in items" :key="`common-account-field-more-${index}`"
          @click="$emit('OnMoreListClick', item.value)">
          <v-list-item-title>{{ $t(item.text) }}</v-list-item-title>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-menu>
</template>
<script>
export default {
  name: "common-account-field-more",
  props: {
    items: Array,
    show: {
      type: Boolean,
      default: true
    },
  },
  data: () => ({
  }),
}
</script>