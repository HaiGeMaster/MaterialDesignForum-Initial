import '@mdi/font/css/materialdesignicons.css'//注释后请在index.html中引入<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
// import { colors } from 'vuetify/lib'
Vue.use(Vuetify);
export default new Vuetify({
  // theme: {
  //   themes: {
  //     light: {
  //       //primary: colors.teal,
  //       primary: colors.blue,
  //       secondary: colors.orange,
  //       accent: colors.pink,
  //       error: colors.red,
  //     },
  //     dark:{
  //       primary: colors.blue,
  //       secondary: colors.orange,
  //       accent: colors.pink,
  //       error: colors.red,
  //       // primary: colors.orange,
  //       // secondary: colors.green,
  //       // accent: colors.green,
  //       // error: colors.red,
  //     }
  //   },
  // },
});
