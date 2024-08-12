<template>
  <v-card 
  :key="keys"
  :class="[
    classes,
    `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
  ]" 
  :elevation="elevation"
  :rounded="$vuetify.breakpoint.name != 'xs'&&rounded" 
  :outlined="$vuetify.theme.dark&&rounded" 
  :style="{
  'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
  // 'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
  }
  ">
    <v-list class="layout-colourless" style="padding: 0;">
      <v-list-item-group>
        <div v-for="folder in item_data" :key="`${keys}-folder-${folder}`">
          <v-divider :key="`${keys}-divider-${folder}`" v-if="folder != 1"/>
          <ListItem 
          :key="`${keys}-ListItem-${folder}`"
          :title="'page-item-crad-list-recent-' + folder"
          :type='type' 
          subtitle="Test subtitle" 
          time="2023-7-5" 
          :url="`${$G_UrlHeaderLang()}/${type}/${folder}`">
          </ListItem>
        </div>
      </v-list-item-group>
    </v-list>
  </v-card>
</template>
<script>
import ListItem from '@/components/list-item'
export default {
  name: 'page-item-crad-list',
  props: {
    keys: {
      type: String,
      default: 'page-item-crad-list'
    },
    type: {
      type: String,
      default: 'questions'//questions,articles,answers
    },
    classes: {
      type: String,
      default: 'glass-container'
    },
    item_data:{

    },
    elevation:{
      type: Number,
      default: 1
    },
    rounded:{
      type: Boolean,
      default: true
    }
  },
  components: {
    ListItem
  },
}
</script>