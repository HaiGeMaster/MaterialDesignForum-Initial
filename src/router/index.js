import Vue from 'vue'
import VueRouter from 'vue-router'
//import i18n from '@/plugins/i18n'
//import messages from '@/assets/language/language.js'
Vue.use(VueRouter)
//var routes_base = [
const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/index/index.vue'),
  },
  {
    path: '/topics',
    name: 'topics',
    component: () => import('@/views/topics/index.vue')
  },
  {
    path: '/topics/:topic_id',
    name: 'topic',
    component: () => import('@/views/topic/index.vue')
  },
  {
    path: '/questions',
    name: 'questions',
    component: () => import('@/views/questions/index.vue')
  },
  {
    path: '/questions/:question_id',
    name: 'question',
    component: () => import('@/views/question/index.vue')
  },
  {
    path: '/articles',
    name: 'articles',
    component: () => import('@/views/articles/index.vue')
  },
  {
    path: '/articles/:article_id',
    name: 'article',
    component: () => import('@/views/article/index.vue')
  },
  {
    path: '/users/:user_id',
    name: 'user',
    component: () => import('@/views/user/index.vue')
  },
  {
    path: '/users',
    name: 'users',
    component: () => import('@/views/users/index.vue')
  },
  {
    path: '/notifications',
    name: 'notifications',
    component: () => import('@/views/notifications/index.vue')
  },

  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/views/admin/index.vue'),
  },
  {
    path: '/admin/topics',
    name: 'admin-topics',
    component: () => import('@/views/admin/topics/index.vue'),
  },
  {
    path: '/admin/questions',
    name: 'admin-questions',
    component: () => import('@/views/admin/questions/index.vue'),
  },
  {
    path: '/admin/answers',
    name: 'admin-answers',
    component: () => import('@/views/admin/answers/index.vue'),
  },
  {
    path: '/admin/articles',
    name: 'admin-articles',
    component: () => import('@/views/admin/articles/index.vue'),
  },
  {
    path: '/admin/comments',
    name: 'admin-comments',
    component: () => import('@/views/admin/comments/index.vue'),
  },
  {
    path: '/admin/replys',
    name: 'admin-replys',
    component: () => import('@/views/admin/replys/index.vue'),
  },
  {
    path: '/admin/usergroup',
    name: 'admin-usergroup',
    component: () => import('@/views/admin/user_group/index.vue'),
  },
  {
    path: '/admin/users',
    name: 'admin-users',
    component: () => import('@/views/admin/users/index.vue'),
  },
  {
    path: '/admin/reports',
    name: 'admin-reports',
    component: () => import('@/views/admin/reports/index.vue'),
  },
  {
    path: '/admin/options',
    name: 'admin-options',
    component: () => import('@/views/admin/options/index.vue'),
  },

  {
    path: '/:lang([a-z]{2}_[A-Z]{2})',
    name: 'lang',
    component: () => import('@/views/index/index.vue'),
  },
  // {
  //   path: '/:lang([a-z]{2}_[A-Z]{2})/',
  //   name: 'lang-home',
  //   component: () => import('@/views/index/index.vue'),
  // },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/topics',
    name: 'lang-topics',
    component: () => import('@/views/topics/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/topics/:topic_id',
    name: 'lang-topic',
    component: () => import('@/views/topic/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/questions',
    name: 'lang-questions',
    component: () => import('@/views/questions/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/questions/:question_id',
    name: 'lang-question',
    component: () => import('@/views/question/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/articles',
    name: 'lang-articles',
    component: () => import('@/views/articles/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/articles/:article_id',
    name: 'lang-article',
    component: () => import('@/views/article/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/users/:user_id',
    name: 'lang-user',
    component: () => import('@/views/user/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/users',
    name: 'lang-users',
    component: () => import('@/views/users/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/notifications',
    name: 'lang-notifications',
    component: () => import('@/views/notifications/index.vue')
  },
  
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin',
    name: 'lang-admin',
    component: () => import('@/views/admin/index.vue')
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/topics',
    name: 'lang-admin-topics',
    component: () => import('@/views/admin/topics/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/questions',
    name: 'lang-admin-questions',
    component: () => import('@/views/admin/questions/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/answers',
    name: 'lang-admin-answers',
    component: () => import('@/views/admin/answers/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/articles',
    name: 'lang-admin-articles',
    component: () => import('@/views/admin/articles/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/comments',
    name: 'lang-admin-comments',
    component: () => import('@/views/admin/comments/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/replys',
    name: 'lang-admin-replys',
    component: () => import('@/views/admin/replys/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/usergroup',
    name: 'lang-admin-usergroup',
    component: () => import('@/views/admin/user_group/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/users',
    name: 'lang-admin-users',
    component: () => import('@/views/admin/users/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/reports',
    name: 'lang-admin-reports',
    component: () => import('@/views/admin/reports/index.vue'),
  },
  {
    path: '/:lang([a-z]{2}_[A-Z]{2})/admin/options',
    name: 'lang-admin-options',
    component: () => import('@/views/admin/options/index.vue'),
  },

  {
    path: '*',
    name: '404',
    component: () => import('@/views/404/index.vue')
  }
]

// //从messages中获取语言列表
// var langlist = [];
// for(var key in messages){
//   langlist.push(key);
// }
// //将语言列表转换为路由
// var routes_lang = [];
// for(var i=0;i<langlist.length;i++){
//   var lang = langlist[i];
//   var routess = [];
//   for(var j=0;j<routes_base.length;j++){
//     var route = routes_base[j];
//     var route_lang = {
//       path: `/${lang}${route.path}`,
//       name: `${lang}-${route.name}`,
//       component: route.component,
//       //meta: route.meta
//     }
//     routess.push(route_lang);
//   }
//   routes_lang = routes_lang.concat(routess);
// }

// const routes = routes_lang

const router = new VueRouter({
  mode: 'history',
  routes,
})

//如果路由为/，则跳转到/home
// router.beforeEach((to, from, next) => {
//   if (to.path === '/') {
//     next({ path: '/home' })
//   } else if(to.path === `${to.params.lang}/`){
//     next({ path: `/${to.params.lang}/home` })
//   } else if(to.path === '/admin'){
//     next({ path: '/admin/home' })
//   } else if(to.path === `/${to.params.lang}/admin`){
//     next({ path: `/${to.params.lang}/admin/home` })
//   } else {
//     next()
//   }
// })

export default router
