<template>
  <div>
    <div class="mc-avatar-upload">
      <v-file-input outlined truncate-length="15" hide-input prepend-icon="mdi-camera" accept="image/jpeg,image/png"
        label="File input" class="upload-btn" color="primary" @change="" />
    </div>
    <img :src="`${$G_AvatarHandle(avatar, 256)}`" class="avatar">
  </div>
</template>
<script>
export default {
  name: 'avatar-upload',
  props: {
    avatar: {
      type: String,
      default: ''
    }
  },
}
</script>