<template>
  <div>
    <ListHeader v-if="head_item != null" :title="head_title" :item="head_item" :show_total="true" :total="pagination.total" @OnMenuClickCallback="OnMenuClickCallback"/>
		
    <template v-if="data!=null" v-for="(item, index) in data">
      <v-divider />
      <ListItem :key="index" :item="item" :type="type" />
    </template>
    
    <Empty :show="IsEmpty" />
    <Loading v-if="!IsEmpty" :show_text="false" :show_ring="false" :need_margin_bottom="false" :loading="IsLoading" :pagination="pagination" @OnElementEntryViewport="OnElementEntryViewport" />
  </div>
</template>
<script>
import ListHeader from '@/components/list-header/index.vue'
import ListItem from '@/components/list-item/index.vue'
import Loading from '@/components/loading/index.vue'
import Empty from '@/components/empty/index.vue'
export default {
  name: 'page-user-contexts-contexts',
  props: {
    user: {
      type: Object,
      default: null,
    },
    head_title: {
      type: String,
      default: '',
    },
    head_item: {
      type: Array,
      default: null
    },
    type: {
      type: String,
      default: 'questions',//questions, answers, articles
    },
  },
  components: {
    ListHeader,
    ListItem,
    Loading,
    Empty,
  },
  data: () => ({
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
    order: '',
  }),
  methods: {
    OnMenuClickCallback(item, order) {
      //console.log(item, order)
      this.order = order
    },
    OnElementEntryViewport(isEntry) {
      if (this.$route.path != `${this.$G_UrlHeaderLang()}/users`) {
        return
      }
      if (this.IsLoading) {
        return
      }
      if (isEntry) {
        this.IsLoading = true
        //this.GetTopics()
      }
    },
  },
  watch:{
    IsLoading(val){
      this.$emit('IsLoading',val)
    },
    IsEmpty(val){
      this.$emit('IsEmpty',val)
    },
    // head_item:{
    //   handler(val, oldVal){
    //     this.order = val[0].order
    //     console.log(this.order)
    //   },
    //   deep:true
    // }
  },
  mounted() {
    this.order = this.head_item[0].order
    //console.log(this.order)
  },
}
</script>