<template>
  <div class="mc-vote">
    <IconButton icon="mdi-thumb-up" text="Message.Components.Vote.Up" @OnIconButtonClick=""/>
    <IconButton icon="mdi-thumb-down" text="Message.Components.Vote.Down" @OnIconButtonClick=""/>
  </div>
</template>
<script>
import IconButton from '@/components/icon-button/index.vue';
export default {
  name: 'vote',
  components: {
    IconButton,
  },
}
</script>