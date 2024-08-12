<template>
  <div
    class="item"
  >
    <UserLine/>
    <!-- <TipTapEditor class="content" :editable="false"/> -->
    <div class="actions">
      <Vote/>
      <div style="margin-left: 8px;"></div>
      <CommentButton/>
      <v-spacer></v-spacer>
      <OptionsButton/>
    </div>
  </div>
</template>
<script>
import UserLine from '@/components/user-line/index.vue'
import Vote from '@/components/vote/index.vue'
import CommentButton from '@/components/comments/components/comment-button/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
// import TipTapEditor from '@/components/tiptap-editor/index.vue'
export default {
  name: 'page-question-answer-item',
  components:{
    UserLine,
    Vote,
    CommentButton,
    OptionsButton,
    // TipTapEditor,
  }
}
</script>
<style lang="less">
@import "./style.less";
</style>