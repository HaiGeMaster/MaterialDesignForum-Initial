<template>
  <v-dialog v-model="$store.getters.App.Dialog.EditInfo" :fullscreen="$vuetify.breakpoint.name == 'xs'" max-width="530px"
    scrollable style="overflow: hidden;">
    <v-card v-if="user != null" :class="[
      'edit-info-dialog',
      'glass-container',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
    ]" :rounded="$vuetify.breakpoint.name != 'xs'" style="padding-bottom: 8px;overflow: hidden;">
      <div class="dialog-title" @click="$store.getters.App.Dialog.EditInfo = !$store.getters.App.Dialog.EditInfo">
        <v-btn icon class="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        {{ $t('Message.Components.EditInfoDialog.EditInfo') }}
      </div>
      <v-card-text class="dialog-content" :style="{
        'height': $vuetify.breakpoint.name != 'xs' ? '652px' : 'auto',
        'padding': '0',
      }">
        <v-form ref="form">
          <v-text-field v-model="UserName" :label="$t('Message.Components.EditInfoDialog.UserName')"
            :placeholder="$t('Message.Components.EditInfoDialog.UserName')" :rules="[
              v => !!v || $t('Message.Components.EditInfoDialog.CannotBeEmpty'),
              v => (v || '').length <= 100 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 100),
            ]"></v-text-field>
          <v-text-field v-model="OneSentenceIntroduction"
            :label="$t('Message.Components.EditInfoDialog.OneSentenceIntroduction')"
            :placeholder="$t('Message.Components.EditInfoDialog.OneSentenceIntroduction')" :rules="[
              v => (v || '').length <= 40 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 40),
            ]"></v-text-field>
          <v-text-field v-model="PersonalHomepage" :label="$t('Message.Components.EditInfoDialog.PersonalHomepage')"
            :placeholder="$t('Message.Components.EditInfoDialog.PersonalHomepage')" :rules="[
              v => (v || '').length <= 40 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 40),
            ]"></v-text-field>
          <v-text-field v-model="AffiliatedSchoolOrEnterprise"
            :label="$t('Message.Components.EditInfoDialog.AffiliatedSchoolOrEnterprise')"
            :placeholder="$t('Message.Components.EditInfoDialog.AffiliatedSchoolOrEnterprise')" :rules="[
              v => (v || '').length <= 80 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 40),
            ]"></v-text-field>
          <v-text-field v-model="Location" :label="$t('Message.Components.EditInfoDialog.Location')"
            :placeholder="$t('Message.Components.EditInfoDialog.Location')" :rules="[
              v => (v || '').length <= 80 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 80),
            ]"></v-text-field>
          <!-- <v-text-field
            :label="个人简介"
            :placeholder="帐号昵称"
          ></v-text-field> -->
          <v-textarea v-model="PersonalIntroduction" :label="$t('Message.Components.EditInfoDialog.PersonalIntroduction')"
            :hint="$t('Message.Components.EditInfoDialog.PersonalIntroduction')" :rules="[
              v => (v || '').length <= 160 || $t('Message.Components.EditInfoDialog.LengthCannotExceedNCharacters').replace('%s', 160),
            ]"></v-textarea>

        </v-form>

      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="$store.getters.App.Dialog.EditInfo = !$store.getters.App.Dialog.EditInfo" :loading="IsLoading">{{
          $t('Message.Components.EditInfoDialog.Cancel') }}</v-btn>
        <v-btn text color="primary" @click="OnSubmitEditInfo()">{{ $t('Message.Components.EditInfoDialog.Save') }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>

export default {
  name: 'edit-info-dialog',
  props: {
    user: {
      type: Object,
      default: null,
    }
  },
  data: () => ({
    //dialog: true,
    UserName: '',
    OneSentenceIntroduction: '',
    PersonalHomepage: '',
    AffiliatedSchoolOrEnterprise: '',
    Location: '',
    PersonalIntroduction: '',
    IsLoading: false,
  }),
  components: {
    //Follow,
  },
  watch: {
    user: {
      handler: function (val, oldVal) {
        if (val != null) {
          this.UserName = val.username;
          this.OneSentenceIntroduction = val.headline;
          this.PersonalHomepage = val.blog;
          this.AffiliatedSchoolOrEnterprise = val.company;
          this.Location = val.location;
          this.PersonalIntroduction = val.bio;
        }
      },
      deep: true
    }
  },
  methods: {
    OnSubmitEditInfo() {

      if(this.$refs.form.validate()==false){
        return
      }
      this.IsLoading = true;
      this.$axios.post('/api/user/editinfo', {
        username: this.UserName,
        headline: this.OneSentenceIntroduction,
        blog: this.PersonalHomepage,
        company: this.AffiliatedSchoolOrEnterprise,
        location: this.Location,
        bio: this.PersonalIntroduction,
        user_token: this.$store.getters.App.UserToken || localStorage.getItem('token') || this.$cookies.get('token') || '',
        edit_target_user_id: this.user.user_id||0,
      }).then(response => {
        if (response.data.is_edit) {
          //this.$store.getters.App.User = response.data.user;
          this.$emit('OnUserUpdate', response.data.user)
          this.$store.getters.App.Dialog.EditInfo = false
          //刷新页面
          this.$router.go(0)
        }else{
          
          this.$G_SAlert(this.$t('Message.Components.Account.TheUsernameCanOnlyBeUniqueOrTheEmailHasBeenRegisteredOrTheVerificationCodeIsIncorrect'))
        }
        this.IsLoading = false;
      }).catch(error => {
        this.IsLoading = false;
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      })
    }
  }
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
@import "../../utils/mixin.less";

.edit-info-dialog {
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

