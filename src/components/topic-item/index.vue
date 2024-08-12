<template>
  <div class="mc-topic-item item-inner">
    <v-card
    :color="$vuetify.theme.dark ? 'layout-dark-color-3' : ''"
    outlined :rounded="$store.getters.App.Style.rounded"
    class="item glass-container" :to="url" >
      <v-img :src="images" max-height="140px">
      </v-img>
      <v-card-title>{{ name }}</v-card-title>
      <div class="actions">
        <Follow :id="topic_id" :callback="null" />
        <v-btn text class="followers grey--text text--darken-1" @click.stop.prevent="
          $emit('OnItemOpenTopicFollowers',topic_id)">
          {{ followers +" "+ $t('Message.Components.Tpoic_Item.Followers') }}
        </v-btn>
      </div>
    </v-card>
  </div>
</template>
<script>
import router from '@/router'
import Follow from '@/components/follow/index.vue'
export default {
  name: "topic-item",
  props:{
    topic_id: Number,
    images: {
      type: String,
      default: require('@/assets/images/test.webp'),
    },
    name: {
      type: String,
      default: "ToLink",
    },
    url: {
      type: String,
      default: "/topics",
    },
    followers: {
      type: Number,
      default: 0,
    }
  },
  components: {
    Follow,
    router,
  },
  data: () => ({
  }),
  created() {
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
.mc-topic-item {
  .item {
    border-color:#e0e0e0;
    .theme--dark & {
      border-color:#494949;
    }
    margin-bottom: 16px;
    background-repeat: no-repeat;
    background-size: contain;
    @media (max-width: @screen-xs-max) {
      margin-bottom: 8px;
    }
    .item-info {
      display: block;
      box-sizing: border-box;
      padding: 56% 16px 0;
      text-decoration: none;
    }
    .name {
      padding-top: 16px;
      padding-bottom: 8px;
      overflow: hidden;
      font-size: 16px;
      white-space: nowrap;
      text-overflow: ellipsis;
      word-break: break-all;
    }
    .actions {
      display: flex;
      justify-content: space-between;
      padding: 8px 0 8px 16px;
    }
    .followers {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
  }
}
</style>