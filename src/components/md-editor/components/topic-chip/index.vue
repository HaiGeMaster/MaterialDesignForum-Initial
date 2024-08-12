<template>
  <v-select v-model="value" :items="items" solo flat label="Select Item" multiple
  style="max-height: 68px;"
  prepend-icon="mdi-plus"
  >
    <template v-slot:selection="{ item, index }">
      <v-chip v-if="index < 2">
        <v-avatar left>
          <v-icon>mdi-account-circle</v-icon>
        </v-avatar>
        <span>{{ item }}</span>
      </v-chip>
      <span v-if="index === 2" class="grey--text text-caption">
        (+{{ value.length - 2 }})
      </span>
    </template>
  </v-select>
</template>
<script>
export default {
  data: () => ({
    items: ['foo', 'bar', 'fizz', 'buzz', 'fizzbuzz', 'foobar'],
    value: ['foo', 'bar', 'fizz'],
  }),
}
</script>