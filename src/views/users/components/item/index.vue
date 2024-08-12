<template>
  <div class="item-inner">
    <v-card
      v-if="user!=null"
      :class="[
        'item glass-container',
        `${'rounded-'+$store.getters.App.Style.rounded}`
        ]" :to='`${$G_UrlHeaderLang()}/users/${user.user_id}`'
      :color="$vuetify.theme.dark ? 'layout-dark-color-3' : ''" outlined
      >
      <div class="item-info">
        <!-- <div v-if="user_avatar==''" class="avatar" :style="{ backgroundImage: `url(${require('@/assets/images/test.webp')})` }" /> -->
        <!-- <v-badge class="avatar"
          bordered
          bottom
          color="deep-purple accent-4"
          dot
          offset-x="10"
          offset-y="10"
        >
          <v-avatar size="96">
            <v-img :src="$G_AvatarHandle(user.avatar,256)"></v-img>
          </v-avatar>
        </v-badge> -->
        <div class="avatar" 
        :style="{ 
          backgroundImage: `url(${$G_AvatarHandle(user.avatar,256)})`
          }" 
        />
        <div class="username">
          {{ user.username }}
        </div>
        <div class="headline grey--text text--darken-1 subtitle-1">
          {{ user.headline }}
        </div>
      </div>
      <div class="actions">
        <Follow v-if="user.user_id!=$store.getters.App.User.user_id" followable_type="user" :followable_id="user.user_id" :is_follow="user.is_follow"/>
        <div class="flex-grow" />
        <OptionsButton />
      </div>
    </v-card>
  </div>
</template>
<script>
import Follow from '@/components/follow/index.vue';
import OptionsButton from '@/components/options-button/index.vue';
export default {
  name: 'page-users-item',
  props:{
    user:{
      type: Object,
      default: null,
    }
  },
  components: {
    Follow,
    OptionsButton,
  },
  watch:{
    user:{
      handler(val){
        console.log(val);
      },
      deep:true,
    }
  }
}
</script>
<style lang="less">
@import '../../../../vendor/variable.less';
#page-users .item-inner .item {
  margin-bottom: 16px;
  border-color:#e0e0e0;
  .theme--dark & {
    border-color:#494949;
  }
  @media (max-width: @screen-xs-max) {
    margin-bottom: 8px;
  }
  .item-info {
    display: block;
    box-sizing: border-box;
    text-decoration: none;
  }
  .avatar {
    width: 96px;
    height: 96px;
    margin: 24px auto 16px;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 96px 96px;
    border-radius: 50%;
    @media (max-width: @screen-xs-max) {
      width: 80px;
      height: 80px;
      margin: 16px auto 12px;
      background-size: 80px 80px;
    }
  }
  .username,
  .headline {
    padding: 0 16px;
    overflow: hidden;
    white-space: nowrap;
    text-align: center;
    text-overflow: ellipsis;
    word-break: break-all;
  }
  .username {
    height: 20px;
    font-size: 17px;
    line-height: 20px;
  }
  .headline {
    height: 20px;
    margin: 8px 0 16px;
    font-size: 15px;
    line-height: 20px;
    @media (max-width: @screen-xs-max) {
      margin: 8px 0;
    }
  }
  .actions {
    display: flex;
    justify-content: space-between;
    padding: 8px 8px 8px 16px;
  }
}
</style>