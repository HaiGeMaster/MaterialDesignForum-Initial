<template>
  <div class="mc-user-line">
    <UserPopover class="avatar" />
    <a :class="[
      'username',
      {
        'black--text': !$vuetify.theme.dark,
        'white--text': $vuetify.theme.dark,
      }
    ]">
      <a>用户名1</a>
      <v-icon small v-if="is_reply" color="grey">mdi-chevron-double-right</v-icon>
      <a v-if="is_reply" small text>用户名2</a>
    </a>
    <div :class="[
      'headline',
      'overline',
      'grey--text',
      {
        'text--darken-1': !$vuetify.theme.dark,
        'text--lighten-1': $vuetify.theme.dark,
      }
    ]
      ">
      用户一句话
    </div>
    <div class="more">
      <span class="time overline grey--text">
        2023-07-19
      </span>
    </div>
  </div>
</template>
<script>
import UserPopover from '@/components/user-popover/index.vue'
export default {
  name: 'user-line',
  props:{
    is_reply: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    UserPopover,
  },
  data() {
    return {
      gradientColors: [
        '#ff0000', 
        '#00ff00', 
      ],
      gradientIndex: 0, 
    };
  },
}
</script>
<style lang="less">
@keyframes gradient-animation {
  0% {
    background: linear-gradient(45deg, #FFD700, #FFA500);
  }
  50% {
    background: linear-gradient(45deg, #FFA500, #FFD700);
  }
  100% {
    background: linear-gradient(45deg, #FFD700, #FFA500);
  }
}
.animated-gradient {
  animation: gradient-animation 3s infinite;
  animation-fill-mode: forwards;
}
.mc-user-line {
  position: relative;
  height: 40px;
  .avatar {
    float: left;
    width: 40px;
    height: 40px;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 40px 40px;
    border-radius: 50%;
  }
  .username {
    margin-left: 24px;
    font-weight: 500;
    font-size: 15px;
    line-height: 22px;
    a{
      color: black;
      .theme--dark & {
        color: white;
      }
    }
  }
  .headline {
    margin-left: 64px;
    overflow: hidden;
    font-size: 13px;
    line-height: 18px;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
  .more {
    position: absolute;
    top: 0;
    right: 0;
  }
  .time {
    font-size: 13px;
    line-height: 20px;
  }
}</style>