import { Extension } from '@tiptap/core';
import { updateMark, removeMark, pasteRule } from '@tiptap-commands';

export default class CustomLinkExtension extends Extension {
  get name() {
    return 'custom_link';
  }

  get defaultOptions() {
    return {
      openOnClick: true,
    };
  }

  get schema() {
    return {
      attrs: {
        href: {
          default: null,
        },
        target: {
          default: '_blank',
        },
        rel: {
          default: null,
        },
      },
      inclusive: false,
      parseDOM: [
        {
          tag: 'a[href]',
          getAttrs: dom => ({
            href: dom.getAttribute('href'),
            target: dom.getAttribute('target'),
            rel: dom.getAttribute('rel'),
          }),
        },
      ],
      toDOM: mark => [
        'a',
        {
          ...mark.attrs,
          rel: mark.attrs.target === '_blank' ? 'noopener noreferrer' : null,
        },
        0,
      ],
    };
  }

  commands({ type }) {
    return attrs => {
      if (attrs.href) {
        return updateMark(type, attrs);
      }
      return removeMark(type);
    };
  }

  pasteRules({ type }) {
    return [
      pasteRule(
        /((https?|ftp):\/\/[^\s/$.?#].[^\s]*)/i,
        type,
        url => ({ href: url })
      ),
    ];
  }
}