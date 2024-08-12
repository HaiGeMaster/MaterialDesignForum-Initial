<template>
  <div class='mc-list-header'>
    <v-btn icon v-if="show_close" class="close" @click="OnCloseClickCallback()">
      <v-icon>mdi-close</v-icon>
    </v-btn>
    <div class="title">
      {{ 
        show_total?
        $t(title).replace('%s', total)
        :$t(title)
      }}
    </div>
    <v-spacer></v-spacer>
    <v-menu offset-y :rounded="$store.getters.App.Style.rounded">
      <template v-slot:activator="{ attrs, on }">
        <v-btn text v-bind="attrs" v-on="on" class="ma-2" v-show="show_menu">
          {{ $t(menu_title) }}
          <v-icon right dark>
            mdi-menu-down
          </v-icon>
        </v-btn>
      </template>
      <v-list v-if="show_menu">
        <v-list-item v-for="items in item" :key="item.name" @click="OnMenuClickCallback(items.name, items.order)">
          <v-list-item-icon>
            <v-icon v-show="menu_title == items.name">
              mdi-check
            </v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ $t(items.name) }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>
<script>
export default {
  name: 'list-header',
  props:{
    title: {
      type: String,
      default: 'Test',
    },
    item: {
      type: Array,
      default: () => [
        {
          order: '-update_time',
          name: 'Message.Pages.Topic.Contexts.UpdateTime_FromLateToEarly',
        },
        {
          order: 'update_time',
          name: 'Message.Pages.Topic.Contexts.UpdateTime_FromEarlyToLate',
        },
        {
          order: '-vote_count',
          name: 'Message.Pages.Topic.Contexts.Hottest',
        },
      ],
    },
    total: {
      type: Number,
      default: 0,
    },
    show_total:{
      Boolean,
      default:false
    },
    show_close:{
      Boolean,
      default:false
    },
    show_menu:{
      Boolean,
      default:true
    }
  },
  data: () => ({
    menu_title: '',
  }),
  methods: {
    OnMenuClickCallback(item, order) {
      this.menu_title = item
      this.$emit('OnMenuClickCallback', item, order)
    },
    OnCloseClickCallback(){
      this.$emit('OnCloseClickCallback')
    }
  },
  created() {
    this.menu_title = this.item[0].name
  },
  // watch:{
  //   item:{
  //     handler(val, oldVal){
  //       this.OnMenuClickCallback(val[0].name, val[0].order)
  //     },
  //     deep:true
  //   }
  // },
  // mounted() {
  //   this.OnMenuClickCallback(this.item[0].name, this.item[0].order)
  // },
};
</script>
<style lang="less">
@import "../../vendor/variable.less";
.mc-list-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  .title {
    font-size: 18px;
    margin: 8px;
  }
  .menu {
    width: 236px;
  }
  @media (max-width: @screen-xs-max) {
    .title {
      font-size: 16px;
      margin: 4px;
    }
  }
}</style>