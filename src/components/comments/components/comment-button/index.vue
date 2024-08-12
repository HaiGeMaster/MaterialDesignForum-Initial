<template>
  <IconButton icon="mdi-message-reply-text" text="Message.Pages.Question.CommentButton.Comment" @OnIconButtonClick="$emit('OnCommentButtonClick')" />
</template>
<script>
import IconButton from '@/components/icon-button/index.vue'
export default{
  name:'page-question-comment-button',
  components:{
    IconButton,
  },
}
</script>