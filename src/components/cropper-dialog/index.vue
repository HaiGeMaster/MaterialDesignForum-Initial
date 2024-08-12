<template>
  <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="930px" scrollable
    style="overflow: hidden;">
    <v-card :class="[
      'cropper-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="dialog = !dialog">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        图片裁剪
      </div>
      <v-card-text class="dialog-content" :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">
        <!-- <v-container>
          
        </v-container:img="option.img" > -->
        <!-- <div style="padding: 8px;border-radius: 8px;height: inherit;">
          
        </div> -->
        <VueCropper ref="cropper" 
            :output-size="option.size" 
            :output-type="option.outputType" 
            :info="true"
            :full="option.full" 
            :can-move="option.canMove"
            :can-move-box="option.canMoveBox" 
            :fixed-box="fixedBox" 
            :original="option.original"
            :auto-crop="option.autoCrop" 
            :auto-crop-width="autoCropWidth" 
            :auto-crop-height="autoCropHeight"
            :center-box="option.centerBox" 
            @real-time="realTime" 
            :high="option.high" 
            @img-load="imgLoad" 
            mode="auto"
            :max-img-size="option.max" 
            @crop-moving="cropMoving" 
            :limitMinSize="limitMinSize"
            :img="option.img||img||require('@/assets/images/test.webp')" 
          />
      </v-card-text>
      <v-card-actions>
        <input type="file" style="display: none;" ref="file"
        accept="image/png, image/jpeg, image/gif, image/jpg" @change="uploadImg($event, 1)">
        <v-btn text @click="$refs.file.click()" color="accent">
          上传图片
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn text @click="dialog = !dialog" color="secondary">取消</v-btn>
        <v-btn text @click="finish('base64')" color="primary" :loading="isLoadingUpload">确定</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import { VueCropper } from 'vue-cropper'

export default {
  name: 'cropper-dialog-dialog',
  components: {
    VueCropper
  },
  props:{
    autoCropWidth:{//自动截图宽度
      type:Number,
      default:512
    },
    autoCropHeight:{//自动截图高度
      type:Number,
      default:512
    },
    fixedBox:{//固定截图框大小 不允许改变
      type:Boolean,
      default:true
    },
    limitMinSize:{//限制最小裁剪尺寸
      type:Array,
      default:()=>[512,512]
    },
    img:{//图片地址
      type:String,
      default:''
    },
    show:{//是否显示
      type:Boolean,
      default:false
    },
    isLoadingUpload:{//是否显示
      type:Boolean,
      default:false
    },
  },
  data: () => ({
    dialog: false,
    option: {
      model: false,
      modelSrc: '',
      crap: false,
      previews: {},
      lists: [
        {
          img: '',//'https://avatars2.githubusercontent.com/u/15681693?s=460&v=4'
        }
      ],
      img: '',//'https://avatars2.githubusercontent.com/u/15681693?s=460&v=4',
      size: 1,
      full: false,
      outputType: 'png',
      canMove: true,
      //fixedBox: true,//固定截图框大小 不允许改变
      original: true,//false,
      canMoveBox: true,
      autoCrop: true,
      // 只有自动截图开启 宽度高度才生效
      //autoCropWidth: 512,//自动截图宽度
      //autoCropHeight: 512,//自动截图高度
      centerBox: false,//true,//截图框是否被限制在图片里面
      high: true,
      max: 99999,
      show: true,
      fixed: false,
      //fixedNumber: [1, 1],
      //limitMinSize:[512,512]
    },
  }),
  methods: {
    // changeImg() {
    //   this.option.img = this.lists[~~(Math.random() * this.lists.length)].img
    // },
    // startCrop() {
    //   // start
    //   this.crap = true
    //   this.$refs.cropper.startCrop()
    // },
    // stopCrop() {
    //   //  stop
    //   this.crap = false
    //   this.$refs.cropper.stopCrop()
    // },
    // clearCrop() {
    //   // clear
    //   this.$refs.cropper.clearCrop()
    // },
    // refreshCrop() {
    //   // clear
    //   this.$refs.cropper.refresh()
    // },
    // changeScale(num) {
    //   num = num || 1
    //   this.$refs.cropper.changeScale(num)
    // },
    // rotateLeft() {
    //   this.$refs.cropper.rotateLeft()
    // },
    // rotateRight() {
    //   this.$refs.cropper.rotateRight()
    // },
    finish(type) {
      // 输出
      // var test = window.open('about:blank')
      // test.document.body.innerHTML = '图片生成中..'
      if (type === 'blob') {
        this.$refs.cropper.getCropBlob((data) => {
          //console.log(data);
          var img = window.URL.createObjectURL(data)
          this.model = true
          this.modelSrc = img
        })
      } else {
        this.$refs.cropper.getCropData((data) => {
          this.model = true
          this.modelSrc = data
          //console.log(this.modelSrc)
          this.$emit('OnCropperFinish', this.modelSrc)
        })
      }
    },
    // 实时预览函数
    realTime(data) {
      this.previews = data
      //console.log(data)
    },

    // finish2(type) {
    //   this.$refs.cropper2.getCropData((data) => {
    //     this.model = true
    //     this.modelSrc = data
    //   })
    // },
    // finish3(type) {
    //   this.$refs.cropper3.getCropData((data) => {
    //     this.model = true
    //     this.modelSrc = data
    //   })
    // },
    down(type) {
      // event.preventDefault()
      var aLink = document.createElement('a')
      aLink.download = 'demo'
      // 输出
      if (type === 'blob') {
        this.$refs.cropper.getCropBlob((data) => {
          this.downImg = window.URL.createObjectURL(data)
          aLink.href = window.URL.createObjectURL(data)
          aLink.click()
        })
      } else {
        this.$refs.cropper.getCropData((data) => {
          this.downImg = data
          aLink.href = data
          aLink.click()
        })
      }
    },

    uploadImg(e, num) {
      //上传图片
      // this.option.img
      var file = e.target.files[0]
      if (!/\.(gif|jpg|jpeg|png|bmp|GIF|JPG|PNG)$/.test(e.target.value)) {
        alert('.gif,jpeg,jpg,png,bmp')
        return false
      }
      var reader = new FileReader()
      reader.onload = (e) => {
        let data
        if (typeof e.target.result === 'object') {
          // 把Array Buffer转化为blob 如果是base64不需要
          data = window.URL.createObjectURL(new Blob([e.target.result]))
        } else {
          data = e.target.result
        }
        if (num === 1) {
          this.option.img = data
        } else if (num === 2) {
          this.example2.img = data
        }
      }
      // 转化为base64
      // reader.readAsDataURL(file)
      // 转化为blob
      reader.readAsArrayBuffer(file)
    },
    imgLoad(msg) {
      //console.log(msg)
    },
    cropMoving(data) {
      //console.log(data, '截图框当前坐标')
    }
  },
  mounted: function () {
    // console.log(window['vue-cropper'])
  },
  watch:{
    show(val){
      if(val){
        this.dialog=val
      }
    },
    dialog(val){
      if(!val){
        this.$emit('OnCropperClose',val)
      }
    }
  }
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";

.cropper-dialog {
  max-width: 930px;
  height: 94% !important;
  max-height: 720px !important;

  .dialog-title {
    padding: 16px 24px;
    line-height: 36px;
    font-size: 20px;
  }

  .dialog-content {
    padding: 0;
  }

  .dialog-content {
    padding-bottom: 62px;
  }

  .close {
    display: none;
  }

  @media (max-width: @screen-xs-max) {
    .mc-dialog-fullscreen();

    .dialog-title {
      padding: 10px 8px;
      font-size: 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);

      .theme-layout-dark & {
        border-bottom-color: rgba(255, 255, 255, .12);
      }
    }

    .list-item {
      padding-right: 16px;
      padding-left: 16px;
    }

    .close {
      display: inline-block;
      margin-right: 16px;
    }
  }

  // max-width: 530px;

  // .dialog-title {
  //   padding: 16px 24px;
  //   line-height: 36px;
  // }

  // .close {
  //   display: none;
  // }

  // .textfield {
  //   padding-top: 0;
  // }

  // @media (max-width: @screen-xs-max) {
  //   .mc-dialog-fullscreen();

  //   .dialog-title {
  //     padding: 10px 8px;
  //     border-bottom: 1px solid rgba(0, 0, 0, 0.12);
  //   }

  //   .dialog-content {
  //     padding-top: 16px;
  //   }

  //   .close {
  //     display: inline-block;
  //     float: left;
  //     margin-right: 8px;
  //   }
  // }
}
</style>


<!-- import { h } from 'hyperapp';
import mdui from 'mdui';
import $ from 'mdui.jq';
import { unescape } from 'html-escaper';
import './index.less';

const Title = () => (
  <div class="mdui-dialog-title">
    <button class="mdui-btn mdui-btn-icon mdui-ripple close" mdui-dialog-close>
      <i class="mdui-icon material-icons">close</i>
    </button>
    编辑个人信息
  </div>
);

const Textfield = ({ label, maxlength, name, value, type }) => (
  <div
    class="mdui-textfield mdui-textfield-floating-label"
    onupdate={(element) => mdui.updateTextFields(element)}
  >
    <label class="mdui-textfield-label">{label}</label>
    <If condition={type === 'text'}>
      <input
        class="mdui-textfield-input"
        name={name}
        type="text"
        maxlength={maxlength}
        value={unescape(value)}
      />
    </If>
    <If condition={type === 'textfield'}>
      <textarea
        class="mdui-textfield-input"
        name={name}
        maxlength={maxlength}
        value={unescape(value)}
      />
    </If>
  </div>
);

const Content = ({ user }) => (
  <form class="mdui-dialog-content">
    <Textfield
      label="一句话介绍"
      maxlength={40}
      name="headline"
      value={user.headline}
      type="text"
    />
    <Textfield
      label="个人主页"
      maxlength={80}
      name="blog"
      value={user.blog}
      type="text"
    />
    <Textfield
      label="所属学校或企业"
      maxlength={80}
      name="company"
      value={user.company}
      type="text"
    />
    <Textfield
      label="所在地区"
      maxlength={80}
      name="location"
      value={user.location}
      type="text"
    />
    <Textfield
      label="个人简介"
      maxlength={160}
      name="bio"
      value={user.bio}
      type="textfield"
    />
  </form>
);

const Actions = ({ edit_info_submitting }) => (
  <div class="mdui-dialog-actions">
    <button class="mdui-btn" mdui-dialog-close>
      取消
    </button>
    <button
      class="mdui-btn"
      mdui-dialog-confirm
      disabled={edit_info_submitting}
    >
      {edit_info_submitting ? '保存中' : '确定'}
    </button>
  </div>
);

export default ({ user, edit_info_submitting }) => (
  <div
    class="mdui-dialog common-dialog"
    oncreate={(element) => $(element).mutation()}
  >
    <Title />
    <Content user={user} />
    <Actions edit_info_submitting={edit_info_submitting} />
  </div>
); -->