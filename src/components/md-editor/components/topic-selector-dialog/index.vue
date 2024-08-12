<template>
  <v-dialog v-model="$store.getters.App.Dialog.TopicSelector" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px" scrollable
    style="overflow: hidden;">
    <v-card :class="[
      'mc-topic-selector-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title">
        <v-btn icon class="close" @click="$store.getters.App.Dialog.TopicSelector= !$store.getters.App.Dialog.TopicSelector">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        话题选择
      </div>
      <v-card-text id="topic-dialog-list" @scroll="handleScroll" :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">
        <v-list class="layout-colourless">
          <v-list-item-group color="primary" class="dialog-content" multiple v-model="data">
            <v-list-item v-for="i in 100" :key="i">
              <template v-slot:default="{ active }">
                <v-list-item-avatar>
                  <v-img :src="require('@/assets/images/test.webp')"></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>话题 {{ i }}</v-list-item-title>
                  <v-list-item-subtitle>话题简介 {{ i }}</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                  <v-checkbox
                    :input-value="active"
                    color="primary"
                  ></v-checkbox>
                </v-list-item-action>
              </template>
            </v-list-item>
            <Loading :loading="IsLoading" :need_margin_bottom="false" />
          </v-list-item-group>
        </v-list>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import Loading from '@/components/loading/index.vue'
import Empty from '@/components/empty/index.vue'
import ListHeader from '@/components/list-header/index.vue'
export default {
  name: 'topic-selector-dialog',
  props:{
    id: {
      Number,
      default: 0
    },
    type: {
      String,
      default: ''
    },
    // show: {
    //   Boolean,
    //   default: false
    // }
  },
  components: {
    Loading,
    Empty,
    ListHeader
  },
  data: () => ({
    //dialog: false,
    data: [],
    IsLoading: false,
  }),
  methods: {
    handleScroll(event) {
      const scrollDistance = event.target.scrollHeight - event.target.scrollTop - event.target.clientHeight;
      if (scrollDistance <= 0) {
        console.log(`${this.$options.name}到底了`);
      }
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
@import "../../../../utils/mixin.less";
.mc-topic-selector-dialog {
  max-width: 530px;
  height: 94% !important;
  max-height: 720px !important;
  .dialog-title {
    padding: 16px 24px;
    line-height: 36px;
  }
  .dialog-content,
  .list {
    padding: 0;
  }
  .dialog-content {
    padding-bottom: 62px;
  }
  .list-item {
    padding-right: 24px;
    padding-left: 24px;
  }
  .list-item-avatar {
    overflow: hidden;
    img {
      width: auto;
      margin-left: -16px;
      border-radius: 0;
    }
  }
  .close {
    display: none;
  }
  .selected {
    padding: 0 24px 8px;
    line-height: 1;
    .chip {
      margin-right: 8px;
    }
  }
  @media (max-width: 599px) {
    .mc-dialog-fullscreen();
    .dialog-title {
      padding: 10px 8px 10px 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
      .theme--dark & {
        border-bottom-color: rgba(255, 255, 255, .12);
      }
    }
    .selected {
      padding-top: 12px;
    }
    .close {
      display: inline-block;
      float: left;
      margin-right: 16px;
    }
  }
}
</style>