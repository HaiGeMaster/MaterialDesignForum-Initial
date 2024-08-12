<template>
  <div v-if="editor">
    <v-row>
      <v-col>
        <v-btn-toggle tile  borderless>
          <v-btn text @click="editor.chain().focus().toggleBold().run()"
            :disabled="!editor.can().chain().focus().toggleBold().run()"
            :class="{ 'is-active': editor.isActive('bold') }">
            <v-icon>mdi-format-bold</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleItalic().run()"
            :disabled="!editor.can().chain().focus().toggleItalic().run()"
            :class="{ 'is-active': editor.isActive('italic') }">
            <v-icon>mdi-format-italic</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleStrike().run()"
            :disabled="!editor.can().chain().focus().toggleStrike().run()"
            :class="{ 'is-active': editor.isActive('strike') }">
            <v-icon>mdi-format-strikethrough-variant</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleCode().run()"
            :disabled="!editor.can().chain().focus().toggleCode().run()"
            :class="{ 'is-active': editor.isActive('code') }">
            <v-icon>mdi-code-tags</v-icon>
          </v-btn>
        </v-btn-toggle>
      </v-col>
      <v-col>
        <v-btn-toggle>
          <v-btn @click="editor.chain().focus().unsetAllMarks().run()">
            <v-icon>mdi-format-clear</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().clearNodes().run()">
            <v-icon>mdi-close-network-outline</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().setParagraph().run()"
            :class="{ 'is-active': editor.isActive('paragraph') }">
            <v-icon>mdi-format-paragraph</v-icon>
          </v-btn>
        </v-btn-toggle>
      </v-col>
      <v-col>
        <v-btn-toggle>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
            <v-icon>mdi-format-header-1</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
            <v-icon>mdi-format-header-2</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
            <v-icon>mdi-format-header-3</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
            <v-icon>mdi-format-header-4</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }">
            <v-icon>mdi-format-header-5</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }">
            <v-icon>mdi-format-header-6</v-icon>
          </v-btn>
        </v-btn-toggle>
      </v-col>
      <v-col>
        <v-btn-toggle>
          <v-btn @click="editor.chain().focus().toggleBulletList().run()"
            :class="{ 'is-active': editor.isActive('bulletList') }">
            <v-icon>mdi-format-list-bulleted</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleOrderedList().run()"
            :class="{ 'is-active': editor.isActive('orderedList') }">
            <v-icon>mdi-format-list-numbered</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleCodeBlock().run()"
            :class="{ 'is-active': editor.isActive('codeBlock') }">
            <v-icon>mdi-code-braces</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().toggleBlockquote().run()"
            :class="{ 'is-active': editor.isActive('blockquote') }">
            <v-icon>mdi-format-quote-close</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().setHorizontalRule().run()">
            <v-icon>mdi-minus</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().setHardBreak().run()">
            <v-icon>mdi-arrow-down-bold-box-outline</v-icon>
          </v-btn>
        </v-btn-toggle>
      </v-col>
      <v-col>
        <v-btn-toggle>
          <v-btn @click="editor.chain().focus().undo().run()" :disabled="!editor.can().chain().focus().undo().run()">
            <v-icon>mdi-undo</v-icon>
          </v-btn>
          <v-btn @click="editor.chain().focus().redo().run()" :disabled="!editor.can().chain().focus().redo().run()">
            <v-icon>mdi-redo</v-icon>
          </v-btn>
        </v-btn-toggle>
      </v-col>
      <v-col>
      </v-col>
    </v-row>
    <editor-content :editor="editor" />
  </div>
</template>
<script>
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-2'
export default {
  components: {
    EditorContent,
  },
  data() {
    return {
      editor: null,
    }
  },
  mounted() {
    this.editor = new Editor({
      extensions: [
        StarterKit,
      ],
      content: `
        <h2>
          Hi there,
        </h2>
        <p>
          this is a <em>basic</em> example of <strong>tiptap</strong>. Sure, there are all kind of basic text styles you’d probably expect from a text editor. But wait until you see the lists:
        </p>
        <ul>
          <li>
            That’s a bullet list with one …
          </li>
          <li>
            … or two list items.
          </li>
        </ul>
        <p>
          Isn’t that great? And all of that is editable. But wait, there’s more. Let’s try a code block:
        </p>
        <pre><code class="language-css">body {
  display: none;
}</code></pre>
        <p>
          I know, I know, this is impressive. It’s only the tip of the iceberg though. Give it a try and click a little bit around. Don’t forget to check the other examples too.
        </p>
        <blockquote>
          Wow, that’s amazing. Good work, boy! 👏
          <br />
          — Mom
        </blockquote>
      `,
    })
  },
  beforeUnmount() {
    this.editor.destroy()
  },
}
</script>
<style lang="scss">
.ProseMirror {
  >*+* {
    margin-top: 0.75em;
  }
  ul,
  ol {
    padding: 0 1rem;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    line-height: 1.1;
  }
  code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
  }
  pre {
    background: #0D0D0D;
    color: #FFF;
    font-family: 'JetBrainsMono', monospace;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    code {
      color: inherit;
      padding: 0;
      background: none;
      font-size: 0.8rem;
    }
  }
  img {
    max-width: 100%;
    height: auto;
  }
  blockquote {
    padding-left: 1rem;
    border-left: 2px solid rgba(#0D0D0D, 0.1);
  }
  hr {
    border: none;
    border-top: 2px solid rgba(#0D0D0D, 0.1);
    margin: 2rem 0;
  }
}</style>