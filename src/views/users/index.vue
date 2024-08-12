<template>
  <v-container id="page-users"
    :style="`max-width: 1084px;${$vuetify.breakpoint.name != 'xs' ? 'padding-top: 12px;' : 'padding-top: 0px;'}`">
    <!-- <v-subheader class="subheading" key="page-users-subheader" style="margin-top: 4px;">{{
      switchState
    }}</v-subheader>
    <div class="items-wrapper">

      <div id="followees" v-if="ItemShowPage == 'followees'">
        <UserItem v-for="u in followeesData" v-if="$G_IsVaild(followeesData)" :user="u" />
      </div>


      <div id="followers" v-if="ItemShowPage == 'followers'">
        <UserItem v-for="u in followersData" v-if="$G_IsVaild(followersData)" :user="u" />
      </div>


      <div id="recommended" v-if="ItemShowPage == 'recommended'">
        <UserItem v-for="u in recommendedData" v-if="$G_IsVaild(recommendedData)" :user="u" />
      </div>

    </div>
    <Loading
    :loading="IsLoading" 
    :pagination="
      ItemShowPage == 'followees' ? followeesData_pagination : 
      ItemShowPage == 'followers' ? followersData_pagination : 
      ItemShowPage == 'recommended' ? recommendedData_pagination : null
    " 
    @OnElementEntryViewport="OnElementEntryViewport" /> -->

    <!-- <div style="margin-top: 4px;" v-if="
      (this.$store.getters.App.IsLogin&&$route.hash=='#followees')||
      (this.$store.getters.App.IsLogin&&$route.hash=='')
    ">
      <v-subheader class="subheading" key="page-users-subheader-followees">{{
        $t("Message.Pages.Users.FolloweesHeaderTitle").replace("%s", this.followeesData_pagination.total)
      }}</v-subheader>

      <div class="items-wrapper">
        <UserItem v-for="u in recommendedData" :user="u" />
      </div>

      <Loading 
      :loading="IsLoading" 
      :pagination="recommendedData_pagination" 
      @OnElementEntryViewport="OnElementEntryViewport" />
    </div>

    <div style="margin-top: 4px;" v-if="
      this.$store.getters.App.IsLogin&&$route.hash=='#followers'
    ">
      <v-subheader class="subheading" key="page-users-subheader-followers">{{
        $t("Message.Pages.Users.FollowersHeaderTitle").replace("%s", this.followersData_pagination.total)
      }}</v-subheader>

      <div class="items-wrapper">
        <UserItem v-for="u in recommendedData" :user="u" />
      </div>

      <Loading 
      :loading="IsLoading" 
      :pagination="recommendedData_pagination" 
      @OnElementEntryViewport="OnElementEntryViewport" />
    </div>

    <div style="margin-top: 4px;" v-if="
      (this.$store.getters.App.IsLogin&&$route.hash=='#recommended')||
      (!this.$store.getters.App.IsLogin&&$route.hash=='')
    ">
      <v-subheader class="subheading" key="page-users-subheader-recommended">{{
        $t("Message.Pages.Users.RecommendedHeaderTitle")
      }}</v-subheader>

      <div class="items-wrapper">
        <UserItem v-for="u in recommendedData" :user="u" />
      </div>

      <Loading 
      :loading="IsLoading" 
      :pagination="recommendedData_pagination" 
      @OnElementEntryViewport="OnElementEntryViewport" />
    </div> -->

    <v-tabs-items v-model="tab" class="layout-colourless">
      <v-tab-item value="followees">
        <Contexts 
          v-if="tab=='followees'"
          type="followees" 
          :subtitle="'Message.Pages.Users.FolloweesHeaderTitle'" 
          :show_total="true" 
        />
      </v-tab-item>
      <v-tab-item value="followers">
        <Contexts 
          v-if="tab=='followers'"
          type="followers" 
          :subtitle="'Message.Pages.Users.FollowersHeaderTitle'" 
          :show_total="true" 
        />
      </v-tab-item>
      <v-tab-item value="recommended">
        <Contexts 
          v-if="tab=='recommended'"
          type="recommended" 
          :subtitle="'Message.Pages.Users.RecommendedHeaderTitle'" 
        />
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>
<script>
// import UserItem from './components/item/index.vue'
// import Loading from '@/components/loading/index.vue'
import Contexts from './components/contexts/index.vue'
//import Empty from '@/components/empty/index.vue'
export default {
  name: 'page-users',
  components: {
    // UserItem,
    // Loading,
    Contexts,
    //Empty,
  },
  data: () => ({
    tab: 'followees',
  }),
  methods: {
    SwitchWebTitle(to) {
      if (to.path == `${this.$G_UrlHeaderLang()}/users`) {
        this.$G_SetWebSubTitle('Message.Pages.Users.WebSubTitle', true)
        if ((to.hash == '#followees' || to.hash == '') && this.$store.getters.App.IsLogin) {
          this.tab = 'followees'
          this.$G_SetWebSubTitle('Message.Pages.Users.PeopleIFollow')
        } else if (to.hash == '#followers' && this.$store.getters.App.IsLogin) {
          this.tab = 'followers'
          this.$G_SetWebSubTitle('Message.Pages.Users.MyFollowers')
        } else if ((this.$store.getters.App.IsLogin && to.hash == '#recommended') || (!this.$store.getters.App.IsLogin && to.hash == '')) {
          this.tab = 'recommended'
          //console.log('tab:recommended')
          this.$G_SetWebSubTitle('Message.Pages.Users.RecommendedContacts')
        }
      }
    },
  },
  watch: {
    //监听$route，在挂载时执行一次，以后每次$route变化时执行
    $route(to, from) {
      this.SwitchWebTitle(to)
    },
    
    '$store.getters.App.IsLogin'(val, oldVal) {
      if (val != oldVal) {
        //this.OnElementEntryViewport(true)
      }
    },
  },
  mounted() {
    this.SwitchWebTitle(this.$route)
    //this.OnElementEntryViewport(true)
  },
}
</script>
<style lang="less">
@import '../../vendor/variable.less';

#page-topics,
#page-users {
  .subheading {
    padding: 8px 8px 16px;
    font-weight: 400;
    font-size: 15px;
    letter-spacing: 0.04em;

    @media (min-width: @screen-sm-min) {
      padding-bottom: 24px;
      font-size: 16px;
    }
  }

  .items-wrapper {
    margin-right: 0;
    margin-left: 0;

    &::after {
      display: table;
      clear: both;
      content: "";
    }

    @media (min-width: @screen-sm-min){//300px) {
      margin-right: -8px;
      margin-left: -8px;
    }
  }

  .item-inner {
    position: relative;
    float: left;
    box-sizing: border-box;
    width: 50%;

    &:nth-child(odd) {
      padding-right: 4px;
      padding-left: 8px;
    }

    &:nth-child(even) {
      padding-right: 8px;
      padding-left: 4px;
    }

    @media (min-width: @screen-sm-min) {
      width: 33.333333%;
      padding-right: 8px !important;
      padding-left: 8px !important;
    }

    @media (min-width: @screen-md-min) {
      width: 25%;
    }
  }

  .mc-follow {
    min-width: 0;
    padding: 0 8px;
  }
}
</style>