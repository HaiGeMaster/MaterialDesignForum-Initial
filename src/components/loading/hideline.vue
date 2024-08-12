<template>
  <div id="loading" :style="{
    'margin-bottom': $store.getters.App.AddFab.ShowScrollTopBtn && need_margin_bottom
      ?
      (
        $store.getters.App.UserSelectDeviceType == 'mobile'
          ?
          '176px'
          :
          '120px'
      )
      :
      (
        $store.getters.App.UserSelectDeviceType == 'mobile' && need_margin_bottom
          ?
          '176px'
          :
          '0px'
      ),
  }
    ">
    <Loaded :show="!loading" />
    <LoadingRing :show="loading" />
  </div>
</template>
<script>
import Loaded from '@/components/loaded/index.vue';
import LoadingRing from '@/components/loading-ring/index.vue';
export default {
  name: 'loading',
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    pagination: {
      type: Object,
      default: null,
    },
    need_margin_bottom: {
      type: Boolean,
      default: true,
    },
  },
  components: {
    Loaded,
    LoadingRing,
  },
  mounted() {
    const options = {
      root: null,
      threshold: 0.5,
    };

    const observer = new IntersectionObserver(this.handleIntersection, options);
    observer.observe(this.$el);
  },
  methods: {
    handleIntersection(entries) {
      if(this.pagination==null||this.loading){
        return
      }
      var selfs = this
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          //console.log('目标元素进入视口');
          // 执行你需要的操作
          //this.$emit('loading',true);
          if (selfs.pagination.next == null||selfs.pagination.next == 0) {
            //this.$emit('OnPaginationNextIsNull',true)
            return;
          }
          this.$emit('OnElementEntryViewport',true)
        } else {
          //console.log('目标元素离开视口');
          // 执行你需要的操作
          //this.$emit('loading',false);
          if (selfs.pagination.next == null||selfs.pagination.next == 0) {
            return;
          }
          this.$emit('OnElementEntryViewport',false)
        }
      });
    },
  },
}
</script>