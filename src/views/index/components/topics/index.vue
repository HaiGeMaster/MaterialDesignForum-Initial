<template>
  <div class="topics-wrapper">
    <div class="topics" id="home-topics">
      <TopicItem v-for="a in 6" :key="a" :url="`${$G_UrlHeaderLang()}/topics/${a}`" :topic_id="a" @OnItemOpenTopicFollowers="(topic_id)=>$emit('OnItemOpenTopicFollowers',topic_id)"/>
    </div>
    <v-btn fab small @click="jumpTo('left')" class="arrow-left glass-container" v-show="topics_show_arrow_left">
      <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
    <v-btn fab small @click="jumpTo('right')" class="arrow-right glass-container" v-show="topics_show_arrow_right">
      <v-icon>mdi-chevron-right</v-icon>
    </v-btn>
  </div>
</template>
<script>
import TopicItem from '@/components/topic-item/index.vue'
import { scrollHorizontal } from '@/utils/scroll'
export default {
  name: '',
  components: {
    TopicItem,
  },
  data: () => ({
    topics_show_arrow_left: false,
    topics_show_arrow_right: true,
  }),
  methods: {
    jumpTo(position) {
      const element = document.querySelector('#home-topics')
      const isLeft = position === 'left';
      const offset = element.offsetWidth * (isLeft ? -1 : 1);
      var selfs = this;
      scrollHorizontal(element, {
        offset,
        callback: () => {
          selfs.jumpEnd(element);
        },
      });
    },
    jumpEnd(element) {
      this.topics_show_arrow_left=element.scrollLeft > 0
      this.topics_show_arrow_right=element.scrollLeft + element.offsetWidth < element.scrollWidth
    },
  },
  created() {
  },
  watch:{
    topics_show_arrow_right:function(val){
      if(!val){
      }
    },
  }
}
</script>
<style lang="less">
@import '../../../../vendor/variable.less';
#page-index .topics-wrapper {
  position: relative;
  .arrow-left,
  .arrow-right {
    position: absolute;
    top: calc(~'50% - 18px');
    @media (max-width: @screen-xs-max) {
      display: none;
    }
  }
  .arrow-left {
    left: -10px;
  }
  .arrow-right {
    right: -10px;
  }
  .topics {
    box-sizing: border-box;
    width: 100%;
    padding: 0 8px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    &::-webkit-scrollbar {
      width: 0;
      height: 0;
    }
    @media (min-width: @screen-sm-min) {
      padding: 0;
      overflow: hidden;
    }
  }
  .mc-topic-item {
    position: relative;
    display: inline-block;
    float: none;
    box-sizing: border-box;
    width: 46%;
    padding-right: 4px;
    padding-left: 4px;
    padding-bottom: 2px;
    &:first-child {
      padding-left: 8px;
    }
    &:last-child {
      padding-right: 8px;
    }
    @media (min-width: @screen-sm-min) {
      width: 33.333333%;
      padding-right: 8px !important;
      padding-left: 8px !important;
    }
    @media (min-width: @screen-md-min) {
      width: 25%;
    }
    .item {
      margin-bottom: 0;
    }
  }
}
</style>