<template>
  <v-menu :close-on-content-click="false" :nudge-width="280" :open-on-hover="$vuetify.breakpoint.name != 'xs'" :rounded="$store.getters.App.Style.rounded">
    <template v-slot:activator="{ on, attrs }">
      <img :src="require('@/assets/images/test.webp')" class="avatar" v-bind="attrs" v-on="on" @click.stop.prevent/>
    </template>
    <v-card class="mc-user-popover">
      <div class="mc-user-line">
        <a key="avatar" class="avatar" :style="`backgroundImage: url('${require('@/assets/images/test.webp')}')`" />
        <a key="username" :class="[
          'username',
          {
            'black--text': !$vuetify.theme.dark,
            'white--text': $vuetify.theme.dark,
          }
        ]">
          用户名
        </a>
        <div key="headline" :class="[
          'headline',
          'overline',
          'grey--text',
          {
            'text--darken-1': !$vuetify.theme.dark,
            'text--lighten-1': $vuetify.theme.dark,
          }
        ]">
          一句话介绍
        </div>
      </div>
      <div class="stats">
        <v-btn text style="height: 64px;">
          <label :class="[
            'grey--text',
            {
              'text--darken-1': !$vuetify.theme.dark,
              'text--lighten-1': $vuetify.theme.dark,
            }
          ]">{{ $t('Message.Components.UserPopover.Answer') }}</label>
          <span>0</span>
        </v-btn>
        <v-btn text style="height: 64px;">
          <label :class="[
            'grey--text',
            {
              'text--darken-1': !$vuetify.theme.dark,
              'text--lighten-1': $vuetify.theme.dark,
            }
          ]">{{ $t('Message.Components.UserPopover.Article') }}</label>
          <span>0</span>
        </v-btn>
        <v-btn text style="height: 64px;">
          <label :class="[
            'grey--text',
            {
              'text--darken-1': !$vuetify.theme.dark,
              'text--lighten-1': $vuetify.theme.dark,
            }
          ]">{{ $t('Message.Components.UserPopover.Followers') }}</label>
          <span>0</span>
        </v-btn>
      </div>
      <v-card-actions :color="$vuetify.theme.dark ? '' : 'grey lighten-5'" class="bottom">
        <Follow />
        <v-spacer></v-spacer>
        <OptionsButton />
      </v-card-actions>
    </v-card>
  </v-menu>
</template>
<script>
import Follow from '@/components/follow/index.vue'
import OptionsButton from '@/components/options-button/index.vue'
import LoadingRing from '@/components/loading-ring/index.vue'
export default {
  name: 'user-popover',
  components: {
    Follow,
    OptionsButton,
    LoadingRing,
  },
  data() {
    return {
      user: {},
      loading: true,
    }
  },
  computed:{
    TestWebp(){
      return require('@/assets/images/test.webp')
    }
  }
}
</script>
<style lang="less" >
.mc-user-popover {
  .popover {
    z-index: 5999;
    width: 320px;
    padding: 16px;
    overflow: visible;
    cursor: default;
  }
  .mc-user-line {
    height: 48px;
    padding: 16px;
    .avatar {
      float: left;
      width: 48px;
      height: 48px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 48px 48px;
      border-radius: 50%;
    }
    .username {
      margin-left: 16px;
      font-size: 17px;
      line-height: 28px;
    }
    .headline {
      margin-left: 64px;
      font-size: 14px;
      line-height: 20px;
    }
  }
  .stats {
    margin-top: 30px;
    display: flex;
    padding-left: 16px;
    padding-right: 16px;
    .v-btn__content {
      align-items: center;
      color: inherit;
      display: flex;
      flex: 1 0 auto;
      justify-content: inherit;
      line-height: normal;
      position: relative;
      transition: inherit;
      transition-property: opacity;
      flex-direction: column;
    }
    a,
    button {
      display: flex;
      flex: 1;
      flex-direction: column;
      align-items: center;
      min-width: auto;
      padding: 4px 0 3px;
      line-height: 24px;
      label,
      span {
        cursor: pointer;
      }
      label {
        font-size: 13px;
      }
      span {
        font-size: 16px;
      }
    }
  }
  .bottom {
    display: flex;
    justify-content: space-between;
    padding: 16px;
  }
}
</style>