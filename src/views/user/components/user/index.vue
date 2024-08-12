<template>
  <v-card key="user"
  :class="[
			'glass-container',
			'user',
      {
        'rounded-t-0':$vuetify.breakpoint.name != 'xs'
      }
		]"
  :outlined="$vuetify.theme.dark"
  :rounded="$vuetify.breakpoint.name != 'xs'&&$store.getters.App.Style.rounded"
  :style="{
    'border-color': $vuetify.theme.dark?'#494949':'#e0e0e0',
    }"
  >
    <div class="cover" v-if="user!=null"
      :style="`background-image: url(${$G_CoverHandle(user.cover)||require('@/assets/images/test.webp')}); background-position-y: 0px;`">
      <div class="mc-cover-upload" v-if="$store.getters.App.User.user_id == user.user_id">
        <!-- <v-file-input 
        outlined truncate-length="15" hide-input prepend-icon="mdi-camera" accept="image/png"
          label="File input" color="primary" @change="" /> -->
        <!-- <input type="file" name="cover" accept="image/png" style="
          display: none;
          " @change="OnCoverUpload" /> -->
        <v-btn icon @click="OnStartCoverUpload" class="glass-container">
          <v-icon>mdi-camera</v-icon>
        </v-btn>
      </div>
    </div>
    <!-- <v-parallax class="cover" height="500" v-if="user!=null" :src="require('@/assets/images/test.webp')">
      <div class="mc-cover-upload" v-if="$store.getters.App.User.user_id == user.user_id">
        <v-file-input 
        outlined truncate-length="15" hide-input prepend-icon="mdi-camera" accept="image/jpeg,image/png"
          label="File input" color="primary" @change="" />
      </div>
    </v-parallax> -->

    <div class="item-info" v-if="user!=null">
      <div class="avatar-box">
        <div class="mc-avatar-upload" v-if="$store.getters.App.User.user_id == user.user_id">
          <!-- <v-file-input outlined truncate-length="15" hide-input prepend-icon="mdi-camera" accept="image/png"
            label="File input" class="upload-btn" color="primary" @change="OnAvatarUpload" /> -->
          <!-- <input type="file" name="avatar" accept="image/png" style="
            display: none;
            " @change="OnAvatarUpload" /> -->
          <v-btn icon class="upload-btn glass-container" @click="OnStartAvatarUpload">
            <v-icon>mdi-camera</v-icon>
          </v-btn>
        </div>
        <img :src="`${$G_AvatarHandle(user.avatar,512)}`" ref="avatar" id="user-avatar" class="avatar">
        <!-- <AvatarUpload :avatar="avatar" /> -->
      </div>
      <div :class="fold ? 'profile fold' : 'profile'">
        <div class="meta username" v-if="user!=null">{{ user.username }}</div>
        <template>
          <div v-for="(item,index) in profileData" :key="index" class="meta" v-if="item.content!=''">
            <v-tooltip bottom >
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">{{ item.icon }}</v-icon>
              </template>
              <span>{{ $t(item.title) }}</span>
            </v-tooltip>
            {{ item.content }}
          </div>
        </template>
        <v-btn v-show="profileDataLength > 1" class="fold-button" text @click="fold = !fold">
          <v-icon>{{ fold ? 'mdi-chevron-down' : 'mdi-chevron-up' }}</v-icon>
          {{ fold ? $t('Message.Pages.User.User.ShowDetail') : $t('Message.Pages.User.User.CollapseDetails') }}
        </v-btn>
      </div>
    </div>
    <div class="actions" v-if="user!=null">
      <v-btn 
      v-if="$store.getters.App.User.user_id == user.user_id && user!=null"
      class="edit" 
      @click="$store.getters.App.Dialog.EditInfo = !$store.getters.App.Dialog.EditInfo"
      outlined icon :color="$vuetify.theme.dark ? 'grey darken-3' : 'grey lighten-2'">
        <v-icon color="grey darken-1">mdi-pencil</v-icon>
      </v-btn>
      <Follow 
      v-if="$store.getters.App.User.user_id != user.user_id && user!=null"
      :is_follow="user.is_follow"
      followable_type="user"
      :followable_id="user.user_id"
      />
      <div class="follow">
        <v-btn class="followers" text
        @click="UsersDialogShowMode = 'followers';UsersDialogShow = true"
        >{{ $t('Message.Pages.User.User.NPeopleFollowing').replace('%s', user.follower_count)
        }}</v-btn>
        <div class="divider"></div>
        <v-btn class="followees" text
        @click="UsersDialogShowMode = 'followees';UsersDialogShow = true"
        >{{ $t('Message.Pages.User.User.FollowNPeople').replace('%s', user.followee_count) }}</v-btn>
      </div>
      <div class="flex-grow"></div>
      <div class="mc-options-button">
        <OptionsButton />
      </div>
    </div>
    <!-- <EditInfoDialog :user="user" @OnUserUpdate="(val)=>{$emit('OnUserUpdate',val)}"/> -->
      <CropperDialog
      :isLoadingUpload="IsLoadingUpload"
      v-if="user!=null"
      :show="CropperShow"
      :autoCropWidth="CropperAutoCropWidth"
      :autoCropHeight="CropperAutoCropHeight"
      :fixedBox="CropperFixedBox"
      :limitMinSize="CropperLimitMinSize"
      :img="CropperImg"
      @OnCropperClose="CropperShow=false"
      @OnCropperFinish="OnCropperFinish"
      />
      <UsersDialog  v-if="user!=null" :id="user.user_id" type="user" :show="UsersDialogShow" :modes="UsersDialogShowMode" @OnUsersDialogClose="UsersDialogShow=false"/>
  </v-card>
</template>
<script>
import OptionsButton from '@/components/options-button/index.vue'
//import AvatarUpload from '@/components/avatar-upload/index.vue'
import EditInfoDialog from '@/components/edit-info-dialog/index.vue'
import Follow from '@/components/follow/index.vue'
import UsersDialog from '@/components/users-dialog/index.vue'
import CropperDialog from '@/components/cropper-dialog/index.vue'
export default {
  name: 'page-user-user',
  components: {
    OptionsButton,
    //AvatarUpload
    EditInfoDialog,
    Follow,
    UsersDialog,
    CropperDialog,
  },
  props:{
    user:{
      type: Object,
      default: null
    }
  },
  data: () => ({
    IsLoadingUpload: false,
    CropperShow: false,
    CropperAutoCropWidth: 1,
    CropperAutoCropHeight: 1,
    CropperFixedBox: true,
    CropperLimitMinSize: [512, 512],
    CropperImg: '',
    CropperMode: 'avatar',//avatar,cover
    UsersDialogShowMode: 'followers',//followers,followees
    UsersDialogShow: false,
    //User:{},
    fold: true,
    followers_count: 0,
    followees_count: 0,
    avatar: '',
    profileData:[
      {
        icon: 'mdi-credit-card-outline',
        title: 'Message.Pages.User.User.OneSentenceIntroduction',//headline
        content: 'Message.Pages.User.User.OneSentenceIntroduction',
      },
      {
        icon: 'mdi-link',
        title: 'Message.Pages.User.User.PersonalHomepage',//bio
        content: 'Message.Pages.User.User.PersonalHomepage',
      },
      {
        icon: 'mdi-city',
        title: 'Message.Pages.User.User.AffiliatedSchoolOrEnterprise',//blog
        content: 'Message.Pages.User.User.AffiliatedSchoolOrEnterprise',
      },
      {
        icon: 'mdi-map-marker',
        title: 'Message.Pages.User.User.Location',//company
        content: 'Message.Pages.User.User.Location',
      },
      {
        icon: 'mdi-file-document',
        title: 'Message.Pages.User.User.PersonalIntroduction',//location
        content: 'Message.Pages.User.User.PersonalIntroduction',
      }
    ],
    profileDataLength: 0,
    IsSetCoverScroll: false,
    AvatarImageData: null,
    AvatarImageBase64: null,
    CoverImageData: null,
    //selectedFileAvatar: null,
  }),
  computed:{
    // HandleAvatar(){
    //   if(this.user.avatar!=''){
    //     //console.log(this.user.avatar)
    //     var a = this.user.avatar
    //     return a.replace('{size}',256)
    //   }
    // },
  },
  methods:{
    OnAvatarImgLoad(e) {
      // console.log(e);
      // return
      // const imgElement = e.target; // 获取触发事件的图片元素

      // // 创建一个隐藏的Canvas元素
      // const canvas = document.createElement('canvas');
      // const ctx = canvas.getContext('2d');

      // // 设置Canvas尺寸与图片尺寸相同
      // canvas.width = imgElement.width;
      // canvas.height = imgElement.height;

      // // 将图片绘制到Canvas上
      // ctx.drawImage(imgElement.img, 0, 0);

      // // 将Canvas内容转换为Base64编码
      // const base64 = canvas.toDataURL();

      // console.log('Image base64:', base64);
      // this.AvatarImageBase64 = base64
      // canvas.remove()
    },
    OnCropperFinish(val){
      if(this.CropperMode=='avatar'){
        this.AvatarImageData = val
      }else if(this.CropperMode=='cover'){
        this.CoverImageData = val
      }
    },
    OnStartAvatarUpload(){
      //document.querySelector('input[name=avatar]').click();
      //读取this.$G_AvatarHandle(this.user.avatar,512)图片并转换为base64
      // var img = new Image();
      // img.src = this.$G_AvatarHandle(this.user.avatar,512);
      // var selfs = this

      // img.onload = 
      //const imgElement = document.querySelector('#user-avatar'); // 获取触发事件的图片元素
      // const imgElement = this.$refs.avatar; // 获取触发事件的图片元素
      // // 创建一个隐藏的Canvas元素
      // const canvas = document.createElement('canvas');
      // const ctx = canvas.getContext('2d');

      // // 设置Canvas尺寸与图片尺寸相同
      // canvas.width = imgElement.width;
      // canvas.height = imgElement.height;

      

      // // 将图片绘制到Canvas上
      // ctx.drawImage(imgElement, 0, 0);

      // // 将Canvas内容转换为Base64编码
      // const base64 = canvas.toDataURL();

      // console.log('Image base64:', base64);
      // //this.AvatarImageBase64 = base64
      // canvas.remove()

      this.CropperImg = this.$G_AvatarHandle(this.user.avatar,512)
      this.CropperAutoCropWidth = 512
      this.CropperAutoCropHeight = 512
      this.CropperFixedBox = true
      this.CropperLimitMinSize = [512, 512]
      this.CropperShow = true
      this.CropperMode = 'avatar'
    },
    // OnAvatarUpload(e) {
    //   // 获取选中的文件
    //   var file = e.target.files[0];

    //   // 创建 FileReader 对象
    //   var reader = new FileReader();
    //   var selfs = this;
    //   var imageData = null;

    //   // 设置读取完成后的回调函数
    //   reader.onload = function (evt) {
    //     // 读取完成后获取图片数据 base64 格式
    //     imageData = evt.target.result;

    //     // 在此处对图片数据进行操作，例如展示图片预览等
    //     //console.log(selfs.AvatarImageData);
    //   };

    //   // 开始读取文件
    //   reader.readAsDataURL(file);

    //   // 创建 Image 对象
    //   var image = new Image();

    //   // 设置加载完成后的回调函数
    //   image.onload = function () {
    //     // 获取图片的宽度和高度
    //     var width = this.width;
    //     var height = this.height;

    //     // 在此处进行分辨率检查或其他操作
    //     // console.log('图片宽度: ' + width);
    //     // console.log('图片高度: ' + height);
    //     if(width<512||height<512){
    //       selfs.$G_SAlert(selfs.$t('Message.Components.TopicsDialog.TheImageResolutionCannotBeLowerThanN').replace('%s', '512*512'));
    //       return;
    //     }else{
    //       selfs.AvatarImageData = imageData;
    //       console.log(selfs.AvatarImageData);
    //     }
    //   };

    //   // 将文件对象赋值给 Image 对象的 src 属性
    //   image.src = URL.createObjectURL(file);

    //   //销毁image
    //   image = null;
    //   //this.AvatarImageData = e.target.files[0];
    // },
    OnStartCoverUpload(){
      //document.querySelector('input[name=cover]').click();
      this.CropperImg = this.$G_CoverHandle(this.user.cover)
      this.CropperAutoCropWidth = 800
      this.CropperAutoCropHeight = 450
      this.CropperFixedBox = true
      this.CropperLimitMinSize = [800, 450]
      this.CropperShow = true
      this.CropperMode = 'cover'
    },
    // OnCoverUpload(e) {
    //   //console.log(e.target.files[0])
    //   // 获取选中的文件
    //   var file = e.target.files[0];

    //   // 创建 FileReader 对象
    //   var reader = new FileReader();
    //   var selfs = this;
    //   var imageData = null;

    //   // 设置读取完成后的回调函数
    //   reader.onload = function (evt) {
    //     // 读取完成后获取图片数据 base64 格式
    //     imageData = evt.target.result;

    //     // 在此处对图片数据进行操作，例如展示图片预览等
    //     //console.log(selfs.CoverImageData);
    //   };

    //   // 开始读取文件
    //   reader.readAsDataURL(file);

    //   // 创建 Image 对象
    //   var image = new Image();

    //   // 设置加载完成后的回调函数
    //   image.onload = function () {
    //     // 获取图片的宽度和高度
    //     var width = this.width;
    //     var height = this.height;

    //     // 在此处进行分辨率检查或其他操作
    //     // console.log('图片宽度: ' + width);
    //     // console.log('图片高度: ' + height);
    //     if(width<512||height<512){
    //       console.log('return')
    //       selfs.$G_SAlert(selfs.$t('Message.Components.TopicsDialog.TheImageResolutionCannotBeLowerThanN').replace('%s', '512*512'));
    //       return;
    //     }else{
    //       selfs.CoverImageData = imageData;
    //       console.log(selfs.CoverImageData);
    //     }
    //   };

    //   // 将文件对象赋值给 Image 对象的 src 属性
    //   image.src = URL.createObjectURL(file);

    //   //销毁image
    //   image = null;
    //   //this.AvatarImageData = e.target.files[0];
    // },
    HandleProfileData(){
      let profileDatas = []
      let textArr = [
        'headline',
        'blog',
        'company',
        'location',
        'bio',
      ]
      this.profileDataLength = 0
      for(let i=0;i<textArr.length;i++){
        if(this.user[textArr[i]]!=''&&this.user[textArr[i]]!=null){
          profileDatas.push({
            icon: this.profileData[i].icon,
            title: this.profileData[i].title,
            content: this.user[textArr[i]],
          })
          this.profileDataLength++
          //console.log(this.user[textArr[i]])
        }
      }
      this.profileData = []
      this.profileData = profileDatas
      ////console.log(profileDatas)
    },
    // OnUserUpdate(val){
    //   this.$store.getters.App.User = val;
    //   this.user = val;
    //   this.$forceUpdate();
    // }
    OnCoverScroll(){
      if(this.IsSetCoverScroll){
        //console.log('return')
        return
      }
      var cover = document.querySelector('.cover');
      // while(cover==null){
      //   cover = document.querySelector('.cover');
      // }
      var selfs = this
      if(cover!=null){
        //console.log('cover')
        setTimeout(() => {
          window.addEventListener('scroll', () => {
            window.requestAnimationFrame(() => {
              cover.style['background-position-y'] = `${
                window.scrollY / 2
              }px`;
            });
          });
          // 向下滚动一段距离
          window.scrollTo(0,cover.getBoundingClientRect().top - document.documentElement.clientHeight * 0.58);
          selfs.IsSetCoverScroll = true
          //$(cover).width() * 0.56 * 0.58);
        }, 1);
      }
    }
  },
  watch:{
    user(val){
      if(val!=null){
        // this.avatar = val.avatar.replace('{size}',256)
        // // //console.log(val.avatar)
        // // //console.log(val.followers_count)
        // // //console.log(val.followees_count)
        // if(val.followers_count===undefined){
        //   this.followers_count = 0
        // }else{
        //   this.followers_count = val.followers_count
        // }
        // if(val.followees_count===undefined){
        //   this.followees_count = 0
        // }else{
        //   this.followees_count = val.followees_count
        // }
        //this.followers_count = val.followers_count
        //this.followees_count = val.followees_count
        this.HandleProfileData()
        //this.OnCoverScroll()
        //强制更新
        this.$forceUpdate()
      }
    },
    '$store.getters.App.AddFab.ScrollPercentage'(val){
      if(val>0){
        if(this.IsSetCoverScroll){
          //console.log('return')
          return
        }
        this.OnCoverScroll()
      }
    },
    AvatarImageData(val){
      // const formData = new FormData();
      // formData.append('image', val);
      // formData.append('user_token', this.$store.getters.App.UserToken);
      this.IsLoadingUpload = true
      this.$axios.post('/api/user/avatar/upload',
      {
        avatar: val,
        user_token: this.$store.getters.App.UserToken,
      }
      ).then(response => {
        // 处理请求成功的响应
        if(response.data.is_upload==true){
          //this.$G_SAlert(this.$t('Message.Components.Account.UploadSuccess'))
          //this.$store.getters.App.User.avatar = response.data.avatar
          //this.user.avatar = response.data.user.avatar
          console.log(response.data.user)
          //this.$emit('OnUserUpdate',response.data.user)
          this.$forceUpdate()
          //刷新页面
          this.$router.go(0)
        }else{
          this.$G_SAlert(this.$t('Message.Components.Account.UploadFailure'))
        }
        this.IsLoadingUpload = false
        //console.log(response.data);
      }).catch(error => {
        // 处理请求失败的错误
        //console.error(error);
        this.IsLoadingUpload = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    },
    CoverImageData(val){
      // const formData = new FormData();
      // formData.append('image', val);
      // formData.append('user_token', this.$store.getters.App.UserToken);
      this.$axios.post('/api/user/cover/upload',
      {
        cover: val,
        user_token: this.$store.getters.App.UserToken,
      }
      ).then(response => {
        // 处理请求成功的响应
        if(response.data.is_upload==true){
          //this.$G_SAlert(this.$t('Message.Components.Account.UploadSuccess'))
          //this.$store.getters.App.User.cover = response.data.cover
          //this.user.cover = response.data.user.cover
          console.log(response.data.user)
          //this.$emit('OnUserUpdate',response.data.user)
          this.$forceUpdate()
          //刷新页面
          this.$router.go(0)
        }else{
          this.$G_SAlert(this.$t('Message.Components.Account.UploadFailure'))
        }
        this.IsLoadingUpload = false
        //console.log(response.data);
      }).catch(error => {
        // 处理请求失败的错误
        //console.error(error);
        this.IsLoadingUpload = false
        this.$G_SAlert(this.$t('Message.Components.Account.RequestFailure'))
      });
    }
  },
  mounted(){
    //this.OnCoverScroll()
  }
}
</script>
<style lang="less">
@import '../../../../vendor/variable.less';
.v-input__prepend-outer{
  margin: auto !important;
}
.mc-avatar-upload {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
#page-user .user {
  // border-top-left-radius: 0;
  // border-top-right-radius: 0;
  // border-bottom-left-radius: 8px;
  // border-bottom-right-radius: 8px;
  .cover {
    position: relative;
    box-sizing: border-box;
    height: 0;
    padding-bottom: 56%; 
    overflow: visible;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    .mc-cover-upload {
      position: absolute;
      top: 16px;
      right: 16px;
      display: none;
    }
    &:hover .mc-cover-upload {
      display: block;
      //border: #868686 solid 1px;
      //background-color: #868686;
      //border-radius: 8px;
    }
  }
  .item-info {
    position: relative;
    display: flex;
    padding: 20px 24px 20px 20px;
    .avatar-box {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 110px;
      min-width: 110px;
      height: 110px;
      background-color: rgba(0, 0, 0, .06);
      border-radius: 50%;
      .theme--dark & {
        background-color: rgba(255, 255, 255, .06);
      }
      .avatar {
        width: 102px;
        height: 102px;
        border-radius: 50%;
        user-select: none;
      }
      .mc-avatar-upload {
        display: none;
      }
      &:hover .mc-avatar-upload {
        display: block;
        // background-color: #868686;
        // border-radius: 8px;
      }
    }
    .profile {
      padding-left: 32px;
      .meta {
        display: block;
        align-items: center;
        padding-left: 30px;
        line-height: 22px;
        &+.meta {
          margin-top: 8px;
        }
        i {
          float: left;
          margin-left: -30px;
          padding-top: 2px;
          font-size: 18px;
        }
      }
      .username {
        padding-top: 8px;
        padding-bottom: 4px;
        padding-left: 0;
        font-size: 32px;
        line-height: 32px;
      }
      &.fold {
        .meta {
          display: none;
          &:first-child,
          &:nth-child(2) {
            display: block;
          }
        }
      }
      .fold-button {
        margin-top: 8px;
        margin-left: -16px;
      }
    }
  }
  .actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px 16px 57px;
    .mc-follow,
    .edit {
      margin-right: 58px;
    }
    .edit i {
      font-size: 21px;
    }
    .follow {
      display: flex;
      flex: 1;
      align-items: center;
    }
    .divider {
      width: 1px;
      height: 16px;
      margin: 0 8px;
      background-color: rgba(0, 0, 0, .12);
      .theme--dark & {
        background-color: rgba(255, 255, 255, .12);
      }
    }
  }
  @media (max-width: @screen-xs-max) {
    border-radius: 0;
    .cover {
      border-radius: 0;
    }
    .item-info {
      flex-direction: column;
      align-items: center;
      padding: 0 16px 16px;
      .avatar-box {
        width: 106px;
        min-width: 106px;
        height: 106px;
        margin-top: -53px;
      }
      .profile {
        width: 100%;
        padding-left: 0;
        &.fold {
          width: auto;
        }
        .username {
          padding-top: 10px;
          font-size: 24px;
          text-align: center;
        }
      }
    }
    .actions {
      position: relative;
      margin-top: 54px;
      padding: 0 16px 16px;
      .mc-follow,
      .edit {
        margin-right: 0;
      }
      .follow {
        position: absolute;
        top: -54px;
        right: 16px;
        left: 16px;
        border-top: 1px solid rgba(0, 0, 0, .06);
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        .theme--dark & {
          border-color: rgba(255, 255, 255, .06);
        }
      }
      .followers,
      .followees {
        width: 50%;
        border-radius: 0;
      }
      .divider {
        margin: 0;
      }
    }
  }
}
</style>