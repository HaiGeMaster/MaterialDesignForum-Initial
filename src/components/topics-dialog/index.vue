<template>
  <v-dialog v-model="$store.getters.App.Dialog.NewTopic" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px"
    scrollable style="overflow: hidden;">
    <v-card :class="[
      'topics-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="$store.getters.App.Dialog.NewTopic = !$store.getters.App.Dialog.NewTopic">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        {{ $t('Message.Components.TopicsDialog.NewTopic') }}
      </div>
      <v-card-text class="dialog-content" :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">
        <v-form ref="form">
          <v-text-field :label="$t('Message.Components.TopicsDialog.TopicName')" required counter="20" :rules="[
            v => !!v || $t('Message.Components.TopicsDialog.TopicNameCannotBeEmpty'),
            v => (v || '').length <= 20 || $t('Message.Components.TopicsDialog.LengthCannotExceedNCharacters').replace('%s', 20)
          ]">
          </v-text-field>
          <v-textarea :label="$t('Message.Components.TopicsDialog.TopicDescription')" required counter="1000" :rules="[
            v => !!v || $t('Message.Components.TopicsDialog.TopicDescriptionCannotBeEmpty'),
            v => (v || '').length <= 1000 || $t('Message.Components.TopicsDialog.LengthCannotExceedNCharacters').replace('%s', 20)
          ]">
          </v-textarea>

          <div class="cover-wrapper">
            <span class="title">{{ $t('Message.Components.TopicsDialog.TopicImage') }}</span>
            <div class="content">
              <img :src="imageData
                " />
              <input type="file" name="topics-dialog-cover" accept=".png, .jpg, .jpeg" style="
            display: none;
            " @change="OnChange" />
              <div class="placeholder" :title="$t('Message.Components.TopicsDialog.ClickToUploadTopicImage')" @click="
                OnInputClick()
                ">
                <v-icon>mdi-camera</v-icon>
              </div>
            </div>
            <div class="error"></div>
          </div>
        </v-form>

      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text>{{ $t('Message.Components.EditInfoDialog.Cancel') }}</v-btn>
        <v-btn text color="primary">{{ $t('Message.Components.EditInfoDialog.Save') }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  name: 'topics-dialog',
  data: () => ({
    //dialog: true,
    imageData: null,
  }),
  methods: {
    OnInputClick() {
      document.querySelector('input[name=topics-dialog-cover]').click();
    },
    OnChange(e) {
      // 获取选中的文件
      var file = e.target.files[0];

      // 创建 FileReader 对象
      var reader = new FileReader();
      var selfs = this;
      var imageData = null;

      // 设置读取完成后的回调函数
      reader.onload = function (evt) {
        // 读取完成后获取图片数据 base64 格式
        imageData = evt.target.result;

        // 在此处对图片数据进行操作，例如展示图片预览等
        //console.log(selfs.imageData);
      };

      // 开始读取文件
      reader.readAsDataURL(file);

      // 创建 Image 对象
      var image = new Image();

      // 设置加载完成后的回调函数
      image.onload = function () {
        // 获取图片的宽度和高度
        var width = this.width;
        var height = this.height;

        // 在此处进行分辨率检查或其他操作
        // console.log('图片宽度: ' + width);
        // console.log('图片高度: ' + height);
        if(width<450||height<250){
          selfs.$G_SAlert(selfs.$t('Message.Components.TopicsDialog.TheImageResolutionCannotBeLowerThanN').replace('%s', '450*250'));
          return;
        }else{
          selfs.imageData = imageData;
        }
      };

      // 将文件对象赋值给 Image 对象的 src 属性
      image.src = URL.createObjectURL(file);

      //销毁image
      image = null;
    },
    // OnLoad(e) {
    //   console.log(e.width)
    //   console.log(e.height)
    // }
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";

.topics-dialog {
  max-width: 530px;
  height: 94% !important;
  max-height: 720px !important;

  form {
    padding: 0 40px 62px;

    .v-text-field {
      padding-bottom: 28px;
    }
  }

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

  .cover-wrapper {
    margin-top: 4px;

    .title {
      padding-bottom: 8px;
      font-size: 16px;
      transform: scale(.75) translateY(0);
      transform-origin: left;
    }

    .content {
      position: relative;
      width: 100%;
      padding-bottom: 56%;

      .v-image__image,
      img {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        //图片不拉伸
        //object-fit: contain;

      }

      .placeholder {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: 100%;
        height: 100%;
        border: 1px solid rgba(134, 134, 134, 0.42);
        border-radius: 8px;
        cursor: pointer;
        transition: border, box-shadow .2s cubic-bezier(.4, 0, .2, 1);

        i {
          padding: 12px;
          color: #fff;
          font-size: 36px;
          background-color: rgba(0, 0, 0, .26);
          border-radius: 50%;
          transition: color .2s cubic-bezier(.4, 0, .2, 1);
          user-select: none;
        }

        &.selected i {
          color: #fff !important;
          background-color: rgba(0, 0, 0, .26) !important;
        }

        &:hover {
          border-color: rgba(136, 136, 136, 0.87);
          box-shadow: 0 0 0 1px rgba(0, 0, 0, .87);
        }

        .theme--dark & {
          border-color: rgba(255, 255, 255, .7);

          i {
            color: rgba(255, 255, 255, 0.56);
            background-color: rgba(255, 255, 255, .26);
          }

          &:hover {
            border-color: #fff;
            box-shadow: 0 0 0 1px #fff;

            i {
              color: #fff;
            }
          }
        }
      }
    }

    .error {
      height: 28px;
      color: rgba(255, 23, 68, .87);
      font-size: 12px;
      line-height: 28px;
    }

    &.invalid {
      .title {
        color: #ff1744 !important;
      }

      .placeholder {
        border-color: #ff1744 !important;
        box-shadow: 0 0 0 1px #ff1744 !important;
      }
    }
  }

  @media (max-width: @screen-xs-max) {
    .mc-dialog-fullscreen();

    .dialog-title {
      padding: 10px 8px;
      font-size: 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);

      .theme--dark & {
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
