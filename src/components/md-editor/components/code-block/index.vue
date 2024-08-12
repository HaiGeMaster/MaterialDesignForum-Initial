<template>
  <node-view-wrapper class="code-block">
    <v-select :items="languages" label="Code language" v-model="selectedLanguage"
      :color="$vuetify.theme.dark ? 'grey darken-2' : ''" dense solo flat />
    <!-- <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="accent"
          v-bind="attrs"
          v-on="on"
          icon
        >
          <v-icon>mdi-code-braces</v-icon>
        </v-btn>
      </template>
      <v-list height="450px">
        <v-list-item-group
          v-model="selectedLanguage"
          color="primary"
        >
          <v-list-item
            v-for="(item, i) in languages"
            :key="i"
          >
            <v-list-item-title>{{ item }}</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-menu> -->
    <pre>
      <code>
        <node-view-content />
      </code>
    </pre>
  </node-view-wrapper>
</template>
<script>
import { NodeViewContent, nodeViewProps, NodeViewWrapper } from '@tiptap/vue-2'
export default {
  components: {
    NodeViewWrapper,
    NodeViewContent,
  },
  props:{
    nodeViewProps,
  },
  data() {
    return {
      languages: this.extension.options.lowlight.listLanguages(),
    }
  },
  computed: {
    selectedLanguage: {
      get() {
        return this.node.attrs.language
      },
      set(language) {
        this.updateAttributes({ language })
      },
    },
  },
}
</script>
<style lang="less">
.code-block {
  position: relative;
  border-radius: 10px;
  border: #303030 dashed 1px;
  padding-top: 24px;
  padding-left: 16px;
  padding-right: 16px;
  padding-bottom: 2px;
  margin-bottom: 16px;
  background-color: rgba(247, 247, 249, 0.7);
  .theme--dark & {
    background-color: rgba(66, 66, 66, 0.7);
    border: #ffffff dashed 1px;
  }
  .v-input {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    max-width: 130px;
  }
  .theme--light.v-text-field--solo>.v-input__control>.v-input__slot {
    background: #ffffff !important;
  }
  .theme--dark.v-text-field--solo>.v-input__control>.v-input__slot {
    background: #303030 !important;
  }
}
</style>