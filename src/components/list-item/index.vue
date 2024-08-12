<template>
  <v-list-item :to="url" style="height: 60px;border-radius: 8px;" class="layout-colourless">
    <v-list-item-avatar @click.stop>
      <v-avatar size="32">
        <UserPopover/>
      </v-avatar>
    </v-list-item-avatar>

    <v-list-item-content>
      <v-list-item-title v-text="title"></v-list-item-title>

      <v-list-item-subtitle v-text="subtitle" v-if="$vuetify.breakpoint.name != 'xs'"
        class="grey--text"></v-list-item-subtitle>

      <v-list-item-subtitle v-if="$vuetify.breakpoint.name == 'xs'" class="text-caption grey--text">
        {{
          OnItemType
        }}&nbsp;&nbsp;&nbsp;&nbsp;{{
          (type =='messages')?
            $t('Message.Components.List_Item.LatestOnN').replace('%s', time):
            $t('Message.Components.List_Item.PublishedOnN').replace('%s', time)
        }}
      </v-list-item-subtitle>

    </v-list-item-content>

    <v-list-item-action v-if="$vuetify.breakpoint.name != 'xs'">
      <v-list-item-action-text class="hover-show">
        {{
          (type =='messages')?
          $t('Message.Components.List_Item.LatestOnN').replace('%s', time):
          $t('Message.Components.List_Item.PublishedOnN').replace('%s', time)
        }}
      </v-list-item-action-text>

      <v-list-item-action-text>
        {{
          OnItemType
        }}
      </v-list-item-action-text>
    </v-list-item-action>
  </v-list-item>
  <!-- <v-list-item :to="url">
    <v-list-item-avatar @click.stop>
      <v-avatar size="32">
        <UserPopover/>
      </v-avatar>
    </v-list-item-avatar>
    <v-list-item-content>
      <v-list-item-title v-text="title"></v-list-item-title>
      <v-list-item-subtitle v-text="subtitle" v-if="$vuetify.breakpoint.name != 'xs'"
        class="grey--text"></v-list-item-subtitle>
      <v-list-item-subtitle v-if="$vuetify.breakpoint.name == 'xs'" class="text-caption grey--text">
        {{
          OnItemType
        }}&nbsp;&nbsp;&nbsp;&nbsp;{{
          (type =='messages')?
            $t('Message.Components.List_Item.LatestOnN').replace('%s', time):
            $t('Message.Components.List_Item.PublishedOnN').replace('%s', time)
        }}
      </v-list-item-subtitle>
    </v-list-item-content>
    <v-list-item-action v-if="$vuetify.breakpoint.name != 'xs'">
      <div class="text-caption text-right grey--text">
        <div class="hover-show text-right">
          {{
            (type =='messages')?
            $t('Message.Components.List_Item.LatestOnN').replace('%s', time):
            $t('Message.Components.List_Item.PublishedOnN').replace('%s', time)
          }}
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        {{
          OnItemType
        }}
      </div>
    </v-list-item-action>
  </v-list-item> -->
</template>
<script>
import UserPopover from '@/components/user-popover/index.vue'
export default {
  props:{
    id: {
      type: Number,
      default: 0,
    },
    title: {
      type: String,
      default: 'Title',
    },
    subtitle: {
      type: String,
      default: 'Subtitle',
    },
    time: {
      type: String,
      default: '2021-1-1',
    },
    count: {
      type: Number,
      default: 0,
    },
    type: {
      type: String,
      default: 'questions',//questions,articles,answers,messages
    },
    url:{
      type: String,
      default: '/',
    }
  },
  components:{
    UserPopover,
  },
  data: () => ({
  }),
  computed: {
    OnItemType() {
      var a = ''
      switch (this.type) {
        case 'questions':
          a = this.$t('Message.Components.List_Item.NAnswers')
          a = a.replace('%s', this.count)
          break
        case 'articles':
          a = this.$t('Message.Components.List_Item.NComment')
          a = a.replace('%s', this.count)
          break
        case 'answers':
          a = this.$t('Message.Components.List_Item.NComment')
          a = a.replace('%s', this.count)
          break
        case 'messages':
          a = this.$t('Message.Components.List_Item.NMessage')
          a = a.replace('%s', this.count)
          break
      }
      return a
    },
  },
}
</script>
<style lang="less">
.hover-show {
  display: none;
}
.v-list-item:hover .hover-show {
  display: block;
}
</style>