<template>
  <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px" scrollable
    style="overflow: hidden;">
    <v-card :class="[
      'common-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="dialog = !dialog">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        通用对话框
      </div>
      <v-card-text class="dialog-content" :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">

      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  name: 'common-dialog-dialog',
  data: () => ({
    dialog: true,
  }),
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";
.common-dialog {
  max-width: 530px;
  height: 94% !important;
  max-height: 720px !important;

  .dialog-title {
    padding: 16px 24px;
    line-height: 36px;
    font-size: 20px;
  }

  .dialog-content{
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