<template>
  <!-- shift -->
  <v-bottom-navigation v-model="value" color="primary" app grow v-show="$store.getters.App.UserSelectDeviceType=='mobile'"
    id="v-bottom-navigation"
    :class="[
    'fixed-bottom-nav',
    'glass-container',
    {
      'fixed-bottom-nav-no-boxshadow': $store.getters.App.ThemeButton.ElevateOnScroll&&!$store.getters.App.AddFab.ShowScrollTopBtn,
    }]
    "
    >
    <v-tooltip top v-if="!$store.getters.App.IsLogin" v-for="item in com_item" :key="'nologin'+item.routers">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" exact-path
          :to="`${$G_UrlHeaderLang()}${item.routers}`"
          :key="'nologin'+item.routers">
          <span>{{ $t(item.text) }}</span>
          <v-icon>{{ item.icon }}</v-icon>
        </v-btn>
      </template>
      <span>{{ $t(item.text) }}</span>
    </v-tooltip>
    <v-tooltip top v-if="$store.getters.App.IsLogin" v-for="item in login_item" :key="'login'+item.routers">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on"
          :to="item.routers.indexOf('local_user_id') != -1 ? $G_UrlHeaderLang() + item.routers.replace('local_user_id', $store.getters.App.User.user_id) : $G_UrlHeaderLang() + item.routers"
          :key="'nologin'+item.routers" exact-path>
          <span>{{ $t(item.text) }}</span>
          <v-icon>{{ item.icon }}</v-icon>
        </v-btn>
      </template>
      <span>{{ $t(item.text) }}</span>
    </v-tooltip>
  </v-bottom-navigation>
</template>
<script>
export default {
  name: 'nav-footer',
  props:{
    com_item:{
      type:Array,
      default:null,
    },
    login_item:{
      type:Array,
      default:null,
    },
  },
  data: () => ({
    value: 0
  }),
  mounted(){
    const targetNode = document.getElementById('v-bottom-navigation');
    targetNode.addEventListener('transitionend', this.transitionend);
  },
  methods:{
    transitionend(event) {
      if(this.$store.getters.App.UserSelectDeviceType!='mobile'){
        return;
      }
      if(event.target.style.transform == 'translateY(100%)'){
        this.$store.getters.App.NavFooter.Show = false;
      }else{
        this.$store.getters.App.NavFooter.Show = true;
      }
    }
  }
}

// 根据你的描述，可以使用以下 JavaScript 函数来计算在 B 模型上的 A 模型的 a 骨骼点的坐标：

// ```javascript
// function calculateAPosition(aFixedCoord, bBoneCoord, aBoneFixedCoord) {
//   const bBoneToABoneVector = [aBoneFixedCoord[0] - bBoneCoord[0], aBoneFixedCoord[1] - bBoneCoord[1], aBoneFixedCoord[2] - bBoneCoord[2]];
//   const aPosition = [aFixedCoord[0] - bBoneToABoneVector[0], aFixedCoord[1] - bBoneToABoneVector[1], aFixedCoord[2] - bBoneToABoneVector[2]];
  
//   return aPosition;
// }
// ```

// 这个函数接受三个参数：
// - `aFixedCoord` 表示 A 模型的 a 骨骼点相对于自身的固定坐标，为一个包含 x、y、z 值的数组。
// - `bBoneCoord` 表示 B 模型的 b 骨骼点在 B 模型自身坐标系下的坐标，为一个包含 x、y、z 值的数组。
// - `aBoneFixedCoord` 表示 A 模型的 b 骨骼点相对于自身的固定坐标，即你所描述的在 B 模型上的 b 骨骼点的固定坐标。

// 函数内部首先计算出从 B 模型的 b 骨骼点到 A 模型的 b 骨骼点的向量，然后使用该向量将 A 模型的 a 骨骼点从其固定坐标位置进行偏移，得到在 B 模型上的 A 模型的 a 骨骼点坐标，并将其作为返回值返回。

// 你可以根据实际情况调用这个函数并传入相应的参数，例如：

// ```javascript
// const aFixedCoord = [1, 2, 3]; // A 模型的 a 骨骼点相对于自身的固定坐标
// const bBoneCoord = [4, 5, 6]; // B 模型的 b 骨骼点在 B 模型自身坐标系下的坐标
// const aBoneFixedCoord = [7, 8, 9]; // A 模型的 b 骨骼点相对于自身的固定坐标

// const aPositionOnB = calculateAPosition(aFixedCoord, bBoneCoord, aBoneFixedCoord);
// console.log(aPositionOnB); // 输出在 B 模型上的 A 模型的 a 骨骼点坐标
// ```

// 请注意，以上代码仅演示了如何调用该函数，并非完整示例。具体的坐标和模型数据需要根据实际情况进行传入。
</script>
<style lang="less" scoped>
.fixed-bottom-nav {
  position: fixed;
  bottom: 0;
  width: 100%;
  //box-shadow: 0px;
}
// .v-item-group.v-bottom-navigation {
//   box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.2) !important;
// }
.fixed-bottom-nav-no-boxshadow{
  box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.2) !important;
}
</style>