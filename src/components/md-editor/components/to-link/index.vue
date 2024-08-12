<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <!-- <v-btn
          color="red lighten-2"
          dark
          v-bind="attrs"
          v-on="on"
        >
          链接
        </v-btn> -->
        <v-btn text title="当前位置插入链接"
          v-bind="attrs"
          v-on="on"
            :small="$vuetify.breakpoint.name == 'xs' || $store.getters.App.Editor.State != 'maximize'" icon
            @click="">
            <v-icon>mdi-link-variant-plus</v-icon>
          </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5">
          插入链接
        </v-card-title>

        <v-card-text>
          <v-form ref="form">
            <v-text-field
              label="显示链接文字（为空则显示链接地址）"
              placeholder=""
              v-model="text"
            ></v-text-field>
            <v-text-field
              label="链接"
              placeholder=""
              required
              :rules="
              [
                v => !!v || '链接地址不能为空',
                v => /https?:\/\/.+/.test(v) || '链接地址格式不正确',
              ]
              "
              v-model="link"
            ></v-text-field>
          </v-form>
          
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="OnLinkOkClick()"
          >
            确定
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        dialog: false,
        text: '',
        link: '',
      }
    },
    methods:{
      validate () {
        this.$refs.form.validate()
      },
      OnLinkOkClick(){
        this.dialog = false
        var text = `<a href="${this.link}" target="_blank">${this.text==''?this.link:this.text}</a>`;
        this.$emit('OnLinkOkClick',text)
      }
    }
  }
</script>