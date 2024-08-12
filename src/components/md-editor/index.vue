<template>
  <v-expand-transition>
    <v-card v-show="$store.getters.App.Editor.State == 'open' ||
      $store.getters.App.Editor.State == 'maximize' ||
      $store.getters.App.Editor.State == 'moderate'
      "
      :rounded="$vuetify.breakpoint.name != 'xs'"
      :class="[
      'mc-editor',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`,
      {
        'maximize': $vuetify.breakpoint.name != 'xs' && $store.getters.App.Editor.State == 'maximize',
        'minimize': $store.getters.App.Editor.State == 'minimize',
        'with-title': editorWithTitle,
        'with-topics': editorWithTopics,
      }
    ]" id="com-editor"
      :elevation="$store.getters.App.Editor.State == 'maximize' ? 24 : ($store.getters.App.Editor.State == 'minimize' ? 16 : 8)">
      <div :class="['header', {'primary':!$vuetify.theme.dark}]">
        <div class="header-title"
          @dblclick="$store.getters.App.Editor.State == 'minimize' ? EditorStateUpdate('maximize') : EditorStateUpdate('minimize')"
          @click="$store.getters.App.Editor.State == 'minimize' ? $store.getters.App.Editor.State = 'maximize' : null">
          {{ $t(editorTitle) }}
        </div>
        <div class="header-actions">
          <v-btn :small="$vuetify.breakpoint.name != 'xs'" text icon :title="$t('Message.Components.Editor.Minimize')"
            @click="$store.getters.App.Editor.State == 'minimize' ? $store.getters.App.Editor.State = 'maximize' : $store.getters.App.Editor.State = 'minimize'">
            <v-icon color="white">mdi-window-minimize</v-icon>
          </v-btn>
          <v-btn :small="$vuetify.breakpoint.name != 'xs'" text icon :title="$t('Message.Components.Editor.Maximize')"
            v-show="$vuetify.breakpoint.name != 'xs'"
            @click="$store.getters.App.Editor.State == 'maximize' ? EditorStateUpdate('moderate') : EditorStateUpdate('maximize')">
            <v-icon color="white">
              {{ $store.getters.App.Editor.State == 'maximize' ? 'mdi-fullscreen-exit' : 'mdi-window-maximize' }}
            </v-icon>
          </v-btn>
          <v-btn :small="$vuetify.breakpoint.name != 'xs'" text icon
            :title="$t('Message.Components.Editor.SaveAsDraftAndClose')" @click="SaveAsDraftAndClose
            ">
            <v-icon color="white">mdi-close</v-icon>
          </v-btn>
        </div>
      </div>
      <div class="body">
        <v-text-field :placeholder="$t('Message.Components.Editor.PleaseEnterATitle')" v-show="editorWithTitle" />
        <div class="editor-topics" v-show="editorWithTopics" @click="$store.getters.App.Dialog.TopicSelector = !$store.getters.App.Dialog.TopicSelector">
          <!-- <TopicChip /> -->
          <span class="placeholder" :title="$t('Message.Components.Editor.ClickToAddATopic')">
            {{ !$store.getters.App.Dialog.TopicSelector?$t('Message.Components.Editor.PleaseSelectAtLeast1Topic'):'' }}
          </span>
          <v-btn text icon class="add" :title="$t('Message.Components.Editor.ClickToAddATopic')">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </div>
        <div class="editor-toolbar">
          <v-menu offset-y :rounded="$store.getters.App.Style.rounded" open-on-hover>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn text :title="$t('Message.Components.Editor.HTitleGroup')" v-bind="attrs" v-on="on"
                    :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon>
                    <v-icon>mdi-format-header-equal</v-icon>
                  </v-btn>
                </template>
                <v-list class="glass-container">
                  <v-list-item-group>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 1 }).run()">
                      <v-icon>mdi-format-header-1</v-icon>
                    </v-list-item>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 2 }).run()">
                      <v-icon>mdi-format-header-2</v-icon>
                    </v-list-item>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 3 }).run()">
                      <v-icon>mdi-format-header-3</v-icon>
                    </v-list-item>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 4 }).run()">
                      <v-icon>mdi-format-header-4</v-icon>
                    </v-list-item>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 5 }).run()">
                      <v-icon>mdi-format-header-5</v-icon>
                    </v-list-item>
                    <v-list-item @click="editor.chain().focus().toggleHeading({ level: 6 }).run()">
                      <v-icon>mdi-format-header-6</v-icon>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-menu>
          <v-btn text :title="$t('Message.Components.Editor.BulletList')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleBulletList().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('bulletList') }">
            <v-icon>mdi-format-list-bulleted</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.OrderedList')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleOrderedList().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('orderedList') }">
            <v-icon>mdi-format-list-numbered</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.HorizontalRule')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().setHorizontalRule().run()">
            <v-icon>mdi-minus</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.HardBreak')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().setHardBreak().run()">
            <v-icon>mdi-arrow-down-bold-box-outline</v-icon>
          </v-btn>
          <!-- <v-btn text title="当前位置插入链接"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="">
            <v-icon>mdi-link-variant-plus</v-icon>
          </v-btn> -->
          <!-- <Link @OnLinkOkClick="AddLink"/> -->
          <v-btn text :title="$t('Message.Components.Editor.Undo')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().undo().run()" :disabled="!editor.can().chain().focus().undo().run()">
            <v-icon>mdi-undo</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Redo')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().redo().run()" :disabled="!editor.can().chain().focus().redo().run()">
            <v-icon>mdi-redo</v-icon>
          </v-btn>
        </div>
        <EditorContent class="editor-content" style="overflow: auto;" :editor="editor" />
        <div class="editor-toolbar">
          <v-btn color="accent" @click="OnEditorSubmit()" :disabled="editor.getText() == ''">
            {{ editorActionText ? editorActionText : $t('Message.Components.Editor.Release') }}
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Bold')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleBold().run()" :disabled="!editor.can().chain().focus().toggleBold().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('bold') }">
            <v-icon>mdi-format-bold</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Italic')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleItalic().run()"
            :disabled="!editor.can().chain().focus().toggleItalic().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('italic') }">
            <v-icon>mdi-format-italic</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Strike')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleStrike().run()"
            :disabled="!editor.can().chain().focus().toggleStrike().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('strike') }">
            <v-icon>mdi-format-strikethrough-variant</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Code')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleCode().run()" :disabled="!editor.can().chain().focus().toggleCode().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('code') }">
            <v-icon>mdi-code-tags</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.ClearMarks')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().unsetAllMarks().run()">
            <v-icon>mdi-format-clear</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.ClearNodes')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().clearNodes().run()">
            <v-icon>mdi-close-network-outline</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Paragraph')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().setParagraph().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('paragraph') }">
            <v-icon>mdi-format-paragraph</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.CodeBlock')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleCodeBlock().run()"
            :class="{ 'v-item--active v-btn--active': editor.isActive('codeBlock') }">
            <v-icon>mdi-code-braces</v-icon>
          </v-btn>
          <v-btn text :title="$t('Message.Components.Editor.Blockquote')"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="editor.chain().focus().toggleBlockquote().run()">
            <v-icon>mdi-format-quote-close</v-icon>
          </v-btn>
          <!-- <v-divider vertical inset></v-divider> -->
          <v-btn :title="$t('Message.Components.Editor.Delete')" @click="DeleteContentFromLocal" text
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon>
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </div>
      </div>
    </v-card>
    <!-- <TopicSelectorDialog :show="topic_selector_dialog"/> -->
  </v-expand-transition>
</template>
<script>
import StarterKit from '@tiptap/starter-kit'
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight'
import Document from '@tiptap/extension-document'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import { Editor, EditorContent, VueNodeViewRenderer } from '@tiptap/vue-2'
import 'highlight.js/styles/github.css';
import { lowlight } from 'lowlight'
import CodeBlockComponent from './components/code-block/index.vue'
import Link from './components/to-link/index.vue'
export default {
  name: 'md-editor',
  components: {
    EditorContent,
    Link,
  },
  props:{
    editorTitle: {
      type: String,
      default: '',
    },
    editorWithTitle: {//带标题
      type: Boolean,
      default: true,
    },
    editorWithTopics: {//带话题
      type: Boolean,
      default: true,
    },
    editorActionText: {
      type: String,
      default: '',
    },
    editorType:{
      type: String,
      default: 'articles',//articles,questions,answer
    }
  },
  data: () => ({
    editor: null,
  }),
  created() {
    this.editor = new Editor({
      extensions: [
        StarterKit,
        Document,
        Paragraph,
        Text,
        CodeBlockLowlight
          .extend({
            addNodeView() {
              return VueNodeViewRenderer(CodeBlockComponent)
            },
          })
          .configure({ lowlight }),
      ],
      content: 
      `<p>
        That’s a boring paragraph followed by a fenced code block:
        </p>
        <pre><code class="language-javascript">for (var i=1; i <= 20; i++)
        {
          if (i % 15 == 0)
            console.log("FizzBuzz");
          else if (i % 3 == 0)
            console.log("Fizz");
          else if (i % 5 == 0)
            console.log("Buzz");
          else
            console.log(i);
        }</code></pre>
        <p>
          Press Command/Ctrl + Enter to leave the fenced code block and continue typing in boring paragraphs.
        </p>`,
      onUpdate: ({ editor }) => {
        this.SaveContentToLocal()
      },
    });
  },
  mounted(){
    const headerTitle = document.querySelector('.header-title');
    var selfs = this;
    headerTitle.addEventListener('touchstart', function (event) {
      event.preventDefault();
      const initialX = event.touches[0].clientX;
      const initialY = event.touches[0].clientY;
      const editor = document.getElementById('com-editor');
      const editorRect = editor.getBoundingClientRect();
      const initialEditorX = editorRect.left;
      const initialEditorY = editorRect.top;
      document.addEventListener('touchmove', touchMoveHandler);
      document.addEventListener('touchend', touchEndHandler);
      function touchMoveHandler(event) {
        const deltaX = event.touches[0].clientX - initialX;
        const deltaY = event.touches[0].clientY - initialY;
        editor.style.left = `${initialEditorX + deltaX}px`;
        editor.style.top = `${initialEditorY + deltaY}px`;
      }
      function touchEndHandler() {
        document.removeEventListener('touchmove', touchMoveHandler);
        document.removeEventListener('touchend', touchEndHandler);
      }
    });
    headerTitle.addEventListener('mousedown', function (event) {
      event.preventDefault();
      const initialX = event.clientX;
      const initialY = event.clientY;
      const editor = document.getElementById('com-editor');
      const editorRect = editor.getBoundingClientRect();
      const initialEditorX = editorRect.left;
      const initialEditorY = editorRect.top;
      document.addEventListener('mousemove', mouseMoveHandler);
      document.addEventListener('mouseup', mouseUpHandler);
      function mouseMoveHandler(event) {
        if(selfs.$store.getters.App.UserSelectDeviceType=='mobile'){
          editor.style.left = '0px';
          editor.style.top = '0px';
          return
        }
        const deltaX = event.clientX - initialX;
        const deltaY = event.clientY - initialY;
        editor.style.left = `${initialEditorX + deltaX}px`;
        editor.style.top = `${initialEditorY + deltaY}px`;
      }
      function mouseUpHandler() {
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
      }
    });
  },
  methods: {
    SaveAsDraftAndClose(){
      if(this.editor.getText() != ''){
        this.SaveContentToLocal()
        this.$store.getters.App.Editor.State = 'minimize'
      }else{
        this.$store.getters.App.Editor.State = 'close';
      }
    },
    SaveContentToLocal() {
      if(this.editor.getText() != ''){
        var json = JSON.stringify(this.editor.getJSON())
        var to = this.$route
        if(to.hash.indexOf('articles') != -1||to.path==`${this.$G_UrlHeaderLang()}/articles`){
          localStorage.setItem('articles_cache', json)
        }else if(to.hash.indexOf('questions') != -1||to.path==`${this.$G_UrlHeaderLang()}/questions`){
          localStorage.setItem('questions_cache', json)
        }else if(to.path.indexOf(`${this.$G_UrlHeaderLang()}/questions/`) != -1){
          localStorage.setItem('answer_cache', json)
        }
      }
    },
    async EditorStateUpdate(v){
      if(v=='moderate'){
        this.$store.getters.App.Editor.State = 'close'
        setTimeout(() => {
          this.$store.getters.App.Editor.State = 'moderate'
        }, 700);
      }else if(v=='maximize'){
        this.$store.getters.App.Editor.State = 'close'
        setTimeout(() => {
          this.$store.getters.App.Editor.State = 'maximize'
        }, 500);
      }
    },
    DeleteContentFromLocal() {
      var to = this.$route
      if(to.hash.indexOf('articles') != -1||to.path==`${this.$G_UrlHeaderLang()}/articles`){
        localStorage.removeItem('articles_cache')
      }else if(to.hash.indexOf('questions') != -1||to.path==`${this.$G_UrlHeaderLang()}/questions`){
        localStorage.removeItem('questions_cache')
      }else if(to.path.indexOf(`${this.$G_UrlHeaderLang()}/questions/`) != -1){
        localStorage.removeItem('answer_cache')
      }
      this.editor.commands.setContent('')
      this.$store.getters.App.Editor.State = 'close'
    },
    ResetEditorPos(){
      if(this.$store.getters.App.Editor.State=='minimize'||this.$store.getters.App.Editor.State=='close'){
        return
      }
      const editor = document.getElementById('com-editor');
      editor.style.left = '0px';
      editor.style.top = '0px';
    },
    OnEditorSubmit() {
      if (this.editor.getText() == '') {
        return
      }
      this.SaveContentToLocal()
      var html = this.editor.getHTML()
      var text = this.editor.getText()
      console.log(html)
      console.log(text)
    },
  },
  watch: {
    '$route'(to, from) {
      this.SaveContentToLocal()
      this.$store.getters.App.Editor.State = 'close'
    },
    '$store.getters.App.UserSelectDeviceType': {
      handler: function (val, oldVal) {
        if (val == 'mobile') {
          this.ResetEditorPos()
        }
      },
      immediate: true,
    },
  },
  computed: {
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import '../../utils/mixin.less';
.ProseMirror {
  height: 100%;
  outline: none;
  box-shadow: none;
}
.ProseMirror:focus {
  outline: none;
  box-shadow: none;
}
.mc-editor {
  position: fixed;
  right: 100px;
  bottom: 16px;
  z-index: 200;
  display: flex;
  flex-direction: column;
  width: 450px;
  height: 608px;
  overflow: hidden;
  border-radius: 8px 8px 0 0;
  box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
  .header {
    display: flex;
    align-items: center;
    height: 40px;
    user-select: none;
    .theme--dark & {
      background-color: rgba(37, 37, 37,0.8)
    }
  }
  .header-title {
    display: flex;
    flex: 1;
    align-items: center;
    height: 100%;
    padding-left: 16px;
    color: #fff;
    font-size: 14px;
  }
  .header-actions {
    padding-right: 8px;
    padding-left: 8px;
  }
  &.maximize:not(.minimize) {
    right: calc(~'(100% - 736px)/2');
    bottom: 4vh;
    width: 100%;
    max-width: 736px;
    height: 92vh;
    @media (max-width: 736px) {
      right: 0;
      bottom: 0;
      height: 100vh;
      border-radius: 0;
    }
  }
  &.minimize {
    width: 260px;
    height: 40px;
  }
  .body {
    flex: 1;
    padding: 0 16px;
    overflow: hidden;
    .submit {
      min-width: 76px;
      margin-right: 10px;
    }
  }
  .editor-title {
    position: relative;
    box-sizing: border-box;
    width: 100%;
    height: 48px;
    font-size: 16px;
    line-height: 34px;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, .08);
    outline: none;
    .theme--dark & {
      border-color: rgba(255, 255, 255, .12);
    }
  }
  .editor-topics {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    height: 48px;
    border-bottom: 1px solid rgba(0, 0, 0, .08);
    .theme--dark & {
      border-color: rgba(255, 255, 255, .12);
    }
    .placeholder,
    .chip-wrapper {
      display: flex;
      flex: 1;
      align-items: center;
      height: 100%;
      user-select: none;
    }
    .placeholder {
      color: rgba(0, 0, 0, .42);
      cursor: pointer;
      .theme--dark & {
        color: rgba(255, 255, 255, .42);
      }
    }
  }
  .editor-toolbar {
    overflow-x: auto;
    display: flex;
    align-items: center;
    padding: 12px 0;
    box-shadow: inset 0 1px 0 0 rgba(100, 121, 143, 0.122);
    .theme--dark & {
      .editor-toolbar-menu-active {
        background-color: #565656 !important;
      }
      i {
        color: #fff;
      }
    }
  }
  .editor-content {
    height: calc(~'100% - 112px');
    padding: 10px 0;
    &::before {
      .theme--dark & {
        color: rgba(255, 255, 255, .42);
      }
    }
    code{
      background-color: rgba(223, 223, 223, 0.5);
      .theme--dark & {
        background-color: rgba(66, 66, 66,0.7);
      }
    }
    pre {
      outline: none;
      box-shadow: none;
      font-family: 'JetBrainsMono', monospace;
      code {
        background-color: rgba(247, 247, 249, 0) !important;
        padding-left: 6px;
        padding-right: 6px;
        background: none;
        font-size: 0.8rem;
      }
      .hljs-comment,
      .hljs-quote {
        color: #616161;
      }
      .hljs-variable,
      .hljs-template-variable,
      .hljs-attribute,
      .hljs-tag,
      .hljs-name,
      .hljs-regexp,
      .hljs-link,
      .hljs-name,
      .hljs-selector-id,
      .hljs-selector-class {
        color: #F98181;
      }
      .hljs-number,
      .hljs-meta,
      .hljs-built_in,
      .hljs-builtin-name,
      .hljs-literal,
      .hljs-type,
      .hljs-params {
        color: #FBBC88;
      }
      .hljs-string,
      .hljs-symbol,
      .hljs-bullet {
        color: #B9F18D;
      }
      .hljs-keyword,
      .hljs-selector-tag {
        color: #70CFF8;
      }
      .hljs-emphasis {
        font-style: italic;
      }
      .hljs-strong {
        font-weight: 700;
      }
    }
  }
  &.with-title,
  &.with-topics {
    .editor-content {
      height: calc(~'100% - 208px');
    }
  }
  &.with-title.with-topics {
    .editor-content {
      height: calc(~'100% - 230px');
    }
  }
  &.with-title.with-topics.maximize {
    .editor-content {
      height: calc(~'100% - 240px');
    }
  }
  &.rounded-xxl.maximize {
    .editor-content {
      height: calc(~'100% - 124px');
    }
  }
  @media (max-width: @screen-xs-max) {
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100vh;
    border-radius: 0;
    &.minimize {
      width: 100%;
      height: 56px;
    }
    .header {
      height: 56px;
    }
    .header-title {
      font-size: 16px;
    }
    .header-actions {
      i {
        padding: 8px;
        font-size: 20px;
        &:nth-child(2) {
          display: none;
        }
      }
    }
    .icon-maximize {
      display: none;
    }
    .editor-toolbar-menu-italic,
    .editor-toolbar-menu-code,
    .editor-toolbar-menu-ol,
    .editor-toolbar-menu-ul {
      display: none;
    }
    .editor-toolbar-menu {
      width: 36px;
      min-width: 36px;
      height: 36px;
      line-height: 36px;
      i {
        font-size: 22px;
      }
    }
  }
}
</style>