<template>
  <div class="items-container">
    <v-card
      :class="[
        'items',
        'glass-container',
        `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
      ]"
      outlined
      :style="{'border-color': $vuetify.theme.dark?'#494949':'#e0e0e0',}"
      >
      <Header :title="title" :url="header_url" />
      <div class="content">
        <v-list class="layout-colourless"
        style="padding: 0;border-radius: 8px;"
        >
          <v-list-item-group color="primary" rounded>
            <div v-for="i in 5" :key="i">
              <v-divider v-show="$vuetify.breakpoint.name != 'xs'"></v-divider>
              <v-list-item :to="item_type + '/' + i">
                <v-list-item-avatar>
                  <v-avatar size="32">
                    <UserPopover/>
                  </v-avatar>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>标题 {{ i }}</v-list-item-title>
                  <v-list-item-subtitle>标题简介 {{ i }}</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </div>
          </v-list-item-group>
        </v-list>
      </div>
    </v-card>
  </div>
</template>
<script>
import Header from '../header/index.vue'
import UserPopover from '@/components/user-popover/index.vue'
export default {
  name: 'page-index-items',
  props:{
    title: {
      type: String,
      default: 'Title'
    },
    header_url: {
      type: String,
      default: ''
    },
    item_type: {
      type: String,
      default: 'questions'
    }
  },
  components: {
    Header,
    UserPopover,
  },
  data: () => ({
  }),
  created() {
  },
}
</script>
<style lang="less" scoped>
@import "../../../../vendor/variable.less";
#page-index .items-container {
  position: relative;
  float: left;
  box-sizing: border-box;
  width: 50%;
  margin-bottom: 24px;
  padding-right: 8px;
  padding-left: 8px;
  //padding-bottom: 2px;
  @media (max-width: @screen-sm-max) {
    width: 100%;
  }
  @media (max-width: @screen-xs-max) {
    padding: 0;
  }
  .items {
    @media (max-width: @screen-xs-max) {
      border-right: none;
      border-left: none;
      border-radius: 0;
    }
  }
  .header {
    @media (max-width: @screen-sm-max) {
      padding: 0 16px;
    }
  }
  .item {
    display: flex;
    align-items: center;
    height: 52px;
    padding: 0 24px 0 64px;
    font-size: 15px;
    text-decoration: none;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    transition: background-color .18s cubic-bezier(.4, 0, .2, 1);
    @media (max-width: @screen-sm-max) {
      padding: 0 16px 0 48px;
    }
    @media (max-width: @screen-xs-max) {
      border-top: none;
    }
    .theme--dark & {
      border-top-color: rgba(255, 255, 255, 0.12);
    }
    &:hover {
      background-color: @color-hover-black;
      .theme--dark & {
        background-color: @color-hover-white;
      }
    }
    &:active {
      background-color: #eee;
      .theme--dark & {
        background-color: #484848;
      }
    }
    .title {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
  }
  .mc-user-popover {
    position: absolute;
    left: 24px;
    width: 20px;
    height: 20px;
    @media (max-width: @screen-sm-max) {
      left: 16px;
    }
    &>.avatar {
      position: absolute;
      left: 0;
      width: 100%;
      height: 100%;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 20px 20px;
      border-radius: 50%;
    }
  }
}
</style>