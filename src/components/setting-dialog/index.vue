<template>
  <v-dialog v-model="$store.getters.App.Dialog.Setting" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px"
    scrollable style="overflow: hidden;">
    <v-card :class="[
      'mc-settings-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="$store.getters.App.Dialog.Setting = !$store.getters.App.Dialog.Setting">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        设置
      </div>
      <v-list class="layout-colourless">
        <v-list-group v-model="active" no-action>
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>颜色</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>主色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>中性色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>次要色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group  no-action>
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>语言</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>主色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>中性色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>次要色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-group  no-action>
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>设备类型</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>主色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>中性色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>次要色</v-list-item-title>
              <v-container fluid>
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex7" column>
                      <v-radio label="red" color="red" value="red"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-radio-group v-model="ex8" column>
                      <v-radio label="primary" color="primary" value="primary"></v-radio>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </v-container>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>

    </v-card>
  </v-dialog>
</template>
<script>
export default {
  name: 'settings-dialog',
  data: () => ({
    active: true,
  }),
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";

.mc-settings-dialog {
  max-width: 530px;
  height: 94% !important;
  max-height: 720px !important;

  .dialog-title {
    padding: 16px 24px;
    line-height: 36px;
    font-size: 20px;
  }

  .dialog-content,
  .list {
    padding: 0;
  }

  .dialog-content {
    padding-bottom: 62px;
  }

  .item {
    position: relative;
  }

  .list-item {
    padding: 8px 24px;
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
}
</style>