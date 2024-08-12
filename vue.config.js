const { defineConfig } = require('@vue/cli-service')
const TerserPlugin = require('terser-webpack-plugin');
//const path = require('path');
module.exports = defineConfig({
  //不显示源码
  productionSourceMap: false,


  assetsDir: 'public/themes/MaterialDesign/',
  indexPath: 'public/themes/MaterialDesign/index.html',

  lintOnSave: false,

  transpileDependencies: [
    'vuetify'
  ],

  //选择不检测的文件夹:public/src
  chainWebpack: config => {
    config.module
      .rule('eslint')
      .exclude
      .add('/public/src')
      .end()
  },

  //选择不打包的文件夹:public/phpMyAdmin4.8.5
  // configureWebpack: {
  //   externals: {
  //     // 将 public/phpMyAdmin4.8.5 文件夹作为外部依赖引入
  //     './public/phpMyAdmin4.8.5': 'phpMyAdmin'
  //   }
  // },

  //publicPath: './',

  pluginOptions: {
    i18n: {
      locale: undefined,          // 当前的语言环境，未定义时将使用默认语言环境
      fallbackLocale: undefined,  // 如果当前语言环境中没有找到翻译的内容，将使用回退语言环境
      localeDir: undefined,       // 包含翻译文件的目录路径
      enableInSFC: undefined,     // 是否在单文件组件中启用国际化（Internationalization）
      enableBridge: undefined     // 是否启用 Vue I18n 与其他库的桥接功能
    }
  },

  configureWebpack: {
    // externals:{
    //   'phpMyAdmin4.8.5': 'phpMyAdmin4_8_5'
    // },
    optimization: {
      minimizer: [
        new TerserPlugin({
          // 配置 Terser 插件选项
          terserOptions: {
            // 设置要使用的压缩选项
            compress: {
              drop_console: true, // 删除控制台输出语句
            },
            mangle: true, // 开启代码混淆
            // 其他选项...

            // mangle:{
            //   eval:true,
            //   keep_classnames:true,
            //   keep_fnames:true,
            //   module:true,
            // },

            format: {
              comments: false, //去掉注释
              preamble: "/* HaiGeMaster Developer & MaterialDesignForum For Vuetify */", //添加注释
            },
          },
        }),
      ],
    },
  },

  devServer: {
    watchFiles: {
      paths: [
        '!public/**',
        '!static/**',
      ]
    }
  }
})
