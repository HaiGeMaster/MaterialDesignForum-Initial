<template>
  <v-card :class="[
    classes,
    'item'
    ]" elevation="0">
    <UserLine />
    <div class="content">Test评论</div>
    <div class="actions">
      <Vote />
      <div style="margin-left: 8px;"></div>
      <IconButton icon="mdi-reply" text="Message.Components.Comments.Item.Reply" :smalls="false" @OnIconButtonClick="new_comment_show= !new_comment_show"/>
      <v-spacer></v-spacer>
      <OptionsButton />
    </div>
    <NewComment :show="new_comment_show" :new_comment_need_glass_container="false"/>
    <v-btn text :class="[
      'reply_count',
      {
        'show-replies':show_replies,
      }
    ]" @click="show_replies = !show_replies">
      <v-icon>mdi-menu-down</v-icon>
      <span>
        {{ show_replies ? $t('Message.Components.Comments.Item.CollapseReply') : $t('Message.Components.Comments.Item.ViewNReplies').replace('%s','0')  }}
      </span>
    </v-btn>
    <div class="replies" v-show="show_replies">
      <Reply v-for="a in 13" :key="a"/>
      <v-btn text class="reply_more">
        <v-icon>mdi-subdirectory-arrow-right</v-icon>
        <span>{{ $t('Message.Components.Comments.Item.ShowMoreReplies') }}</span>
      </v-btn>
    </div>
  </v-card>
</template>
<script>
import UserLine from '@/components/user-line/index.vue'
import Vote from '@/components/vote/index.vue'
import IconButton from '@/components/icon-button/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
import Reply from '@/components/comments/components/reply/index.vue'
import NewComment from '@/components/comments/components/new-comment/index.vue'
export default {
  name: 'comments-item',
  props:{
    classes:{
      type:String,
      default:'glass-container'
    }
  },
  components: {
    UserLine,
    Vote,
    IconButton,
    OptionsButton,
    Reply,
    NewComment,
  },
  data() {
    return {
      show_replies:false,
      new_comment_show:false,
    }
  }
}
</script>
<style lang="less">
@import "../../../../vendor/variable.less";
@import "../../../../components/answers/components/item/style.less";
.mc-comments .item {
  border-radius: 0;
  .content {
    line-height: 1.6;
  }
  .actions>.mc-icon-button {
    margin-left: 8px;
    i {
      font-size: 22px;
    }
  }
  .reply_count,
  .reply_more {
    display: inline-block;
    height: 24px;
    color: @primaryColor;
    line-height: 24px;
    cursor: pointer;
    i {
      float: left;
      transition: transform .3s;
    }
    span {
      font-size: 14px;
    }
    .theme--dark & {
      color: @primaryColorDark;
    }
  }
  .reply_more {
    i {
      margin-right: 3px;
      font-size: 20px;
    }
  }
  .show-replies {
    i {
      transform: rotate(180deg);
    }
  }
}
</style>