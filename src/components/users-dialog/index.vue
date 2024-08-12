<template>
  <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px" scrollable
    style="overflow: hidden;">
    <v-card :class="[
      'mc-users-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="dialog= !dialog">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        {{ 
          modes == 'followers' ? 
          $t('Message.Components.UsersDialog.FollowersN').replace('%s', pagination.total) :
          $t('Message.Components.UsersDialog.FolloweesN').replace('%s', pagination.total)
        }}
      </div>
      <!-- @scroll="handleScroll" -->
      <v-card-text id="users-dialog-list"  :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">
        <Empty :show="IsEmpty||data==null"/>
        <v-list class="layout-colourless" v-if="!IsEmpty&&data!=null">
          <v-list-item-group color="primary" class="dialog-content">
            
            <v-list-item v-for="u in data" :key="u.username">
              <v-list-item-avatar>
                <v-img :src="$G_AvatarHandle(u.avatar,128)"></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title v-text="u.username"></v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <Follow v-if="u.user_id!=$store.getters.App.User.user_id" :followable_id="u.user_id" followable_type="user" :is_follow="u.is_follow" />
              </v-list-item-action>
            </v-list-item>
            
          </v-list-item-group>
        </v-list>
        <Loading :need_margin_bottom="false" :loading="IsLoading" :pagination="pagination" @OnElementEntryViewport="OnElementEntryViewport"/>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import Loading from '@/components/loading/index.vue'
import Empty from '@/components/empty/index.vue'
import Follow from '@/components/follow/index.vue'
import ListHeader from '@/components/list-header/index.vue'
export default {
  name: 'users-dialog',
  props:{
    id: {//关注id
      Number,
      default: 0
    },
    type: {//关注类型 user，topic，question，articles
      String,
      default: ''
    },
    show: {
      Boolean,
      default: false
    },
    modes: {
      String,
      default: 'followers',//关注者 followers，关注了 followees
      // () => ([
      //   {
      //     name: '关注者',
      //     value: 'followers'
      //   },
      //   {
      //     name: '关注了',
      //     value: 'followees'
      //   },
      // ])
    },
  },
  components: {
    Loading,
    Empty,
    Follow,
    ListHeader
  },
  data: () => ({
    dialog: false,
    IsLoading: false,
    IsEmpty: true,
    data: null,
    pagination: {
      page: 0,
      per_page: 20,
      total: 0,
      pages: 0,
      previous: 0,
      next: 1
    },
  }),
  methods: {
    // handleScroll(event) {
    //   const scrollDistance = event.target.scrollHeight - event.target.scrollTop - event.target.clientHeight;
    //   if (scrollDistance <= 0) {
    //     //console.log(`${this.$options.name}到底了`);
    //   }
    // }
    OnElementEntryViewport(isEntry) {
      // if (this.$route.path.indexOf('/users/') == -1) {
      //   return
      // }
      if (this.IsLoading) {
        return
      }
      if (isEntry) {
        this.IsLoading = true
        //this.GetTopics()
        if(this.type == 'user'){
          this.GetUsers()
        }
      }
    },
    GetUsers() {
      var token = this.$store.getters.App.UserToken || localStorage.getItem('token') || this.$cookies.get('token') || ''
      this.$axios.post('/api/follow/get', {
        modes: this.modes,
        type: this.type,
        followable_id: this.id,
        page: this.pagination.next,
        user_token: token != '' ? token : '',
      }
      ).then(response => {
        if (response.data.is_get == true) {
          this.data == null ? this.data = response.data.data : response.data.data.forEach((item, index) => {
            //如果item.user_id在this.data 中存在则不添加
            var index = this.data.findIndex(item2 => item2.user_id === item.user_id);
            // 如果找到相同的项，isExist 为 true
            var isExist = index !== -1;
            if (!isExist) {
              this.data.push(item)
            }
          })
          this.pagination = response.data.pagination
          if (response.data.pagination.total == 0) {
            //console.log('IsEmpty:true')
            this.IsEmpty = true
            this.$emit('OnIsEmpty', true)
          } else {
            //console.log('IsEmpty:false')
            this.IsEmpty = false
            this.$emit('OnIsEmpty', false)
          }
        }
        this.IsLoading = false
      }).catch(error => {
        this.IsLoading = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      })
    }
  },
  watch: {
    dialog(val) {
      if (!val) {
        this.$emit('OnUsersDialogClose')
      }
    },
    show(val) {
      if (val) {
        this.dialog = val
      }
    },
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";
.mc-users-dialog {
  max-width: 530px;
  height: 94% !important;
  max-height: 720px !important;
  .dialog-title {
    padding: 16px 24px;
    line-height: 36px;
    font-size: 20px;
  }
  .dialog-content,
  .list {
    padding: 0;
  }
  .dialog-content {
    //padding-bottom: 62px;
  }
  .item {
    position: relative;
  }
  .list-item {
    padding: 8px 24px;
  }
  .close {
    display: none;
  }
  @media (max-width: @screen-xs-max) {
    .mc-dialog-fullscreen();
    .dialog-title {
      padding: 10px 8px;
      font-size: 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
      .theme-layout-dark & {
        border-bottom-color: rgba(255, 255, 255, .12);
      }
    }
    .list-item {
      padding-right: 16px;
      padding-left: 16px;
    }
    .close {
      display: inline-block;
      margin-right: 16px;
    }
  }
}
</style>