// const Vue = require('vue')
// const renderer = require('vue-server-renderer').createRenderer()

import Vue from 'vue'
import Vcr from 'vue-server-renderer'

const app = new Vue({
  data: {
    message: 'Hello, Vue SSR!'
  },
  template: '<div>{{ message }}</div>'
})
Vcr.createRenderer().renderToString(app, (err, html) => {
  if (err) {
    console.error(err)
  } else {
    console.log(html)
  }
})