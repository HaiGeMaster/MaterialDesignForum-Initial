<template>
  <v-card 
  :rounded="$store.getters.App.Style.rounded"
  outlined
  :class="[
    'glass-container',
  ]">
    <v-list-item three-line>
      <v-list-item-content>
        <div class="text-overline mb-4">
          <v-icon color="green">mdi-shield-check</v-icon>
          系统通知
        </div>
        <v-list-item-title class="text-h5 mb-1">
          标题
        </v-list-item-title>
        <v-list-item-subtitle>简单的内容</v-list-item-subtitle>
      </v-list-item-content>

      <v-list-item-avatar tile size="80">
        <!-- <img :src="require('@/assets/images/test.webp')"> -->
        <v-icon>mdi-message-cog</v-icon>
      </v-list-item-avatar>
    </v-list-item>

    <v-card-actions>
      <v-btn x-large text block color="primary">
        查看
        <v-icon>
          mdi-arrow-right
        </v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
export default {
  name: 'message-card',
}
</script>