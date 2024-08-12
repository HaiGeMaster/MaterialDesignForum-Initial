<template>
  <EditorContent :editor="editor" />
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
import CodeBlockComponent from '@/components/md-editor/components/code-block/index.vue'
export default {
  name: 'tiptap-editor',
  props:{
    content: {
      String,
      default: `<p>
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
    },
    editable: {
      Boolean,
      default: true,
    }
  },
  components: {
    EditorContent,
  },
  data: () => ({
    editor: null,
  }),
  created() {
    var selfs = this
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
      content: selfs.content,
      onUpdate: ({ editor }) => {
        this.$emit('OnEditorUpdate')
      },
    })
    this.editor.setEditable(this.editable)
    this.$emit('OnEditorCreated', this.editor)
  },
}
</script>
<style lang="less">
.ProseMirror {
  height: 100%;
  outline: none;
  box-shadow: none;
}
.ProseMirror:focus {
  outline: none;
  box-shadow: none;
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
</style>