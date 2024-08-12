<template>
  <v-btn block class="header" text :to="url">
    {{ title }}
    <v-icon left color="primary">{{ icon }}</v-icon>
  </v-btn>
</template>
<script>
export default {
  name: 'page-index-header',
  props:{
    title: String,
    url: String,
    icon: {
      type: String,
      default: 'mdi-arrow-right'
    },
  },
  data: () => ({
  }),
  created() {
  },
}
</script>
<style lang="less">
#page-index .header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 52px;
  padding: 0 24px;
  font-weight: 500;
  font-size: 16px;
  text-decoration: none;
  i {
    font-size: 18px;
  }
}
</style>