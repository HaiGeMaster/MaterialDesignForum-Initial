<template>
  <div class="item">
    <UserLine />
    <div class="content">Test评论的回复</div>
    <div class="actions">
      <Vote/>
      <v-spacer></v-spacer>
      <OptionsButton/>
    </div>
  </div>
</template>
<script>
import UserLine from '@/components/user-line/index.vue'
import Vote from '@/components/vote/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
export default {
  name: 'comments-reply',
  components: {
    UserLine,
    Vote,
    OptionsButton,
  },
}
</script>
<style lang="less">
@import "../../../../vendor/variable.less";
.mc-comments .item .item {
  border-left: 3px solid #e0e0e0;
  padding-right: 0;
  border-bottom: none;
  .theme--dark & {
    border-left: 3px solid #424242;
  }
  .mc-user-line {
    height: 24px;
    .avatar {
      width: 24px;
      height: 24px;
      background-size: 24px 24px;
    }
    .username {
      margin-left: 16px;
      line-height: 24px;
    }
    .headline {
      display: none;
    }
  }
  .content {
    padding-top: 26px;
  }
  .content,
  .actions {
    padding-left: 40px;
  }
  @media (max-width: 849px) {
    padding-left: 40px;
    .content,
    .actions {
      padding-left: 0;
    }
  }
  @media (max-width: @screen-xs-max) {
    padding-right: 0;
    padding-left: 40px;
  }
}
</style>