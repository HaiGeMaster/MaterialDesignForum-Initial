<template>
  <v-tooltip top
  transition="scale-transition"
  origin="center center">
    <template v-slot:activator="{ on, attrs }">
      <v-fab-transition>
        <v-btn v-show="$store.getters.App.AddFab.ShowScrollTopBtn" elevation="8"
          transition="scale-transition"
          origin="center center"
          fab
          fixed large bottom right
          color="accent" v-bind="attrs" v-on="on" @click="ScrollToTop"
          :style="
          {
            //'transition':'transform 0.3s ease',
            // 'margin-bottom': $store.getters.App.UserSelectDeviceType=='mobile'&&$store.getters.App.NavFooter.Show
            // ?
            //   $route.path.indexOf('/articles/') != -1&&$store.getters.App.AddFab.ScrollMode=='up'?'122px':'56px'
            // :
            //   $route.path.indexOf('/articles/') != -1&&$store.getters.App.AddFab.ScrollMode=='up'
            //   ?
            //     ($store.getters.App.AddFab.ScrollMode!='down'&&WindowWidth<1094)?'64px':'0px'
            //   :
            //     '0px'
            // ,
            // 'transform':$store.getters.App.AddFab.ScrollMode=='down'?'translateY(100%)':'none',
            'transform': $store.getters.App.UserSelectDeviceType=='mobile'&&$store.getters.App.NavFooter.Show
            ?
              $route.path.indexOf('/articles/') != -1&&$store.getters.App.AddFab.ScrollMode=='up'||$store.getters.App.AddFab.NewComment_Select
              ?
                'translateY(-122px)'
              :
                'translateY(-56px)'
            :
              $route.path.indexOf('/articles/') != -1&&$store.getters.App.AddFab.ScrollMode=='up'
              ?
                ($store.getters.App.AddFab.ScrollMode!='down'&&WindowWidth<1094)?'translateY(-64px)':''
              :
                ''
            ,
            'height':$store.getters.App.UserSelectDeviceType == 'mobile'||$vuetify.breakpoint.name == 'xs'?'':'53px',
            'width':$store.getters.App.UserSelectDeviceType == 'mobile'||$vuetify.breakpoint.name == 'xs'?'':'53px',
          }
          "
          >
          <v-progress-circular
            id="totop-v-progress-circular"
            :rotate="-90"
            :value="$store.getters.App.AddFab.ScrollPercentage"
            color="white"
            :size="$store.getters.App.UserSelectDeviceType == 'mobile'||$vuetify.breakpoint.name == 'xs'?66:55"
            :width="3"
          >
            <v-icon color="white" :style="{
              'font-size':$store.getters.App.AddFab.ScrollPercentage>=99?'32px':'28px'
            }">
              mdi-chevron-up
            </v-icon>
          </v-progress-circular>
        </v-btn>
      </v-fab-transition>
    </template>
    <span>{{ $t('Message.Components.ToTopButton.ToTop') }}</span>
  </v-tooltip>
</template>
<script>
import Vue from 'vue'
import { scrollToTop } from '@/utils/scroll'
export default {
  name: 'totop-fab-button',
  props:{
    show:{
      type:Boolean,
      default:false,
    },
  },
  data: () => ({
    WindowWidth:''
  }),
  methods: {
    ScrollToTop() {
      scrollToTop(1000)
    },
  },
  mounted(){
    //监听窗口变化，获取宽度px并存储到this.WindowWidth
    // 监听窗口变化的事件处理函数
    const handleResize = () => {
      this.WindowWidth = window.innerWidth;// + 'px';
    };

    // 初始化时获取一次宽度
    this.WindowWidth = window.innerWidth;// + 'px';

    // 添加窗口变化的监听器
    window.addEventListener('resize', handleResize);

    // 在组件销毁时移除监听器，以防止内存泄漏
    this.$once('hook:beforeDestroy', () => {
      window.removeEventListener('resize', handleResize);
    });
  }
}
</script>
<style lang="less">
#totop-v-progress-circular.v-progress-circular{
  .v-progress-circular__underlay {
    stroke: rgba(0,0,0,0) !important;
    z-index: 1;
  }
}
</style>