<template>
  <div class="mc-comments" 
  
  >
    <v-card :class="[
      'comments-wrapper',
      {
        'glass-container':need_glass_container,
        'layout-colourless':!need_glass_container,
      }
    ]"
    :rounded="$vuetify.breakpoint.name != 'xs'&&need_rounded?$store.getters.App.Style.rounded:$store.getters.App.Style.default_rounded"
    >
      <Item :classes="item_classes"/>
      <v-divider></v-divider>
      <Item :classes="item_classes"/>
      <Loading :loading="IsLoading" v-if="!external_loading"/>
    </v-card>
    <Loading :loading="IsLoading" v-if="external_loading"/>
    <NewComment :show="show_new_comment" 
    :new_comment_need_glass_container="new_comment_need_glass_container"
    :new_comment_rounded_t_or_b="new_comment_rounded_t_or_b"
    />
  </div>
</template>
<script>
import Item from './components/item/index.vue'
import Loading from '@/components/loading/index.vue'
import NewComment from '@/components/comments/components/new-comment/index.vue'
export default {
  name: 'comments',
  props:{
    show_new_comment: {
      type: Boolean,
      default: true,
    },
    external_loading: {
      type: Boolean,
      default: false,
    },
    need_glass_container: {
      type: Boolean,
      default: true,
    },
    need_rounded: {
      type: Boolean,
      default: true,
    },
    new_comment_need_glass_container: {
      type: Boolean,
      default: true,
    },
    new_comment_rounded_t_or_b: {
      type: String,
      default: 't',
    },
    item_classes:{
      type:String,
      default:'glass-container'
    }
  },
  components: {
    Item,
    Loading,
    NewComment,
  },
  data() {
    return {
      IsLoading: false,
      list_header: [
        {
          order: '-update_time',
          name: 'Message.Pages.Topic.Contexts.UpdateTime_FromLateToEarly',
        },
        {
          order: 'update_time',
          name: 'Message.Pages.Topic.Contexts.UpdateTime_FromEarlyToLate',
        },
        {
          order: '-vote_count',
          name: 'Message.Pages.Topic.Contexts.Hottest',
        },
      ],
    }
  }
}
</script>
<style lang="less">
@import "../../vendor/variable.less";
.mc-comments {
  .comments {
    min-height: 148px;
    @media (max-width: @screen-xs-max) {
      border-right: none;
      border-left: none;
      border-radius: 0;
    }
  }
}
</style>