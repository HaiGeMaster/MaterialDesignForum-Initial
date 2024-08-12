import Vue from 'vue'
import App from './App.vue'
import router from './router'//npm install vue-router --save
import store from './store'//npm install vuex --save
import vuetify from './plugins/vuetify'//npm install vuetify --save
import i18n from './plugins/i18n'//npm install vue-i18n --save
import axios from 'axios'//npm install axios --save
//import qs from 'qs';
import cookies from 'vue-cookies';//npm install vue-cookies --save
import './vendor/global.less'

// 设置基础URL，这里假设接口地址为http://example.com/api
axios.defaults.baseURL = 'http://localhost';//打包时按需要选择注释掉。

//axios.defaults.baseURL = 'https://demo.xbedrock.com';//打包时按需要选择注释掉。

// 添加拦截器，设置请求头
axios.interceptors.request.use(function(config) {
  config.headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
  //config.headers['Content-Type'] = 'application/json;';
  // config.headers['Access-Control-Allow-Origin'] = '*';
  // config.headers['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS, PUT, PATCH, DELETE';
  // config.headers['Access-Control-Allow-Headers'] = 'X-Requested-With,content-type';
  // 其他需要设置的请求头信息
  return config;
}, function(error) {
  return Promise.reject(error);
});

Vue.config.productionTip = false
Vue.prototype.$axios = axios
//Vue.prototype.$qs = qs
// Vue.prototype.$mdui = mdui
//Vue.prototype.$mdjq = mduijquery
// Vue.prototype.$mdeditor = mduieditor
// import mdui from 'mdui'
//import mduijquery from 'mdui.jq'
// import mduieditor from 'mdui.editor'
// import 'mdui/dist/css/mdui.min.css'
Vue.use(cookies)
new Vue({
  router,
  store,
  vuetify,
  i18n,
  render: h => h(App),
  beforeMount() {
    //删除id=app的div里面的内容
    document.getElementById('app').innerHTML = '';
  }
}).$mount('#app')