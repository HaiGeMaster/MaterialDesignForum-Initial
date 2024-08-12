<template>
  <v-container id="page-questions"
    :style="$vuetify.breakpoint.name != 'xs' ? 'max-width: 800px;padding:0 16px;' : 'max-width: 800px;padding:0 0px;'">
    <!-- <div :style="{
      'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
    }"> -->

    <div :style="{
      'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '0px',
    }">
      <!-- <ItemCardList :keys="'page-questions-recent'" :type="'questions'" :item_data="10" v-if="(!$store.getters.App.IsLogin && $route.hash == '') ||
        (!$store.getters.App.IsLogin && $route.hash == '#recent') ||
        ($store.getters.App.IsLogin && $route.hash == '') ||
        ($store.getters.App.IsLogin && $route.hash == '#recent')" />
      <ItemCardList :keys="'page-questions-popular'" :type="'questions'" :item_data="20"
        v-if="(!$store.getters.App.IsLogin && $route.hash == '#popular') || ($store.getters.App.IsLogin && $route.hash == '#popular')" />
      <ItemCardList :keys="'page-questions-following'" :type="'questions'" :item_data="30"
        v-if="$store.getters.App.IsLogin && $route.hash == '#following'" /> 
      
        :rounded="$vuetify.breakpoint.name != 'xs'"
              :outlined="$vuetify.theme.dark"
      -->
      <v-tabs-items v-model="tab" class="layout-colourless">
        <v-tab-item value="recent">
          <v-card :class="[
            'glass-container',
          ]"
            :rounded="$vuetify.breakpoint.name != 'xs' ? $store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded"
            outlined :style="{
              'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
              'margin': $vuetify.breakpoint.name != 'xs' ? '6px' : '0px',
            }">
            <v-list class="layout-colourless" style="padding: 0;">
              <ListItem type="questions" v-for="i in 15" :url="`${$G_UrlHeaderLang()}/questions/1`" />
            </v-list>
          </v-card>
          <Loading :loading="IsLoading" />
        </v-tab-item>
        <v-tab-item value="popular">
          <v-card :class="[
            'glass-container',
          ]"
            :rounded="$vuetify.breakpoint.name != 'xs' ? $store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded"
            outlined :style="{
              'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
              'margin': $vuetify.breakpoint.name != 'xs' ? '6px' : '0px',
            }">
            <v-list class="layout-colourless" style="padding: 0;">
              <ListItem type="questions" v-for="i in 15" :url="`${$G_UrlHeaderLang()}/questions/1`" />
            </v-list>
          </v-card>
          <Loading :loading="IsLoading" />
        </v-tab-item>
        <v-tab-item value="following" v-if="$store.getters.App.IsLogin">
          <v-card :class="[
            'glass-container',
          ]"
            :rounded="$vuetify.breakpoint.name != 'xs' ? $store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded"
            outlined :style="{
              'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
              'margin': $vuetify.breakpoint.name != 'xs' ? '6px' : '0px',
            }">
            <v-list class="layout-colourless" style="padding: 0;">
              <ListItem type="questions" v-for="i in 15" :url="`${$G_UrlHeaderLang()}/questions/1`" />
            </v-list>
          </v-card>
          <Loading :loading="IsLoading" />
        </v-tab-item>
      </v-tabs-items>
    </div>

    <!-- <MdEditor :editorTitle="'Message.Components.Editor.NewQuestions'" key="Editor-questions"/> -->
  </v-container>
</template>
<script>
import ListItem from '@/components/list-item/index.vue'
import Loading from '@/components/loading/index.vue'
//import MdEditor from '@/components/md-editor/index.vue'
//import ItemCardList from '@/components/item-card-list/index.vue'
export default {
  name: 'page-questions',
  components: {
    ListItem,
    Loading,
    // MdEditor,
    //ItemCardList,
  },
  data: () => ({
    IsLoading: false,
    tab: 'recent',
  }),
  methods: {
    SwitchWebTitle(to) {
      if (to.path == `${this.$G_UrlHeaderLang()}/questions`) {
        this.$G_SetWebSubTitle('Message.Pages.Questions.WebSubTitle', true)
        if (to.hash == '#recent' || to.hash == '') {
          this.tab = 'recent'
          this.$G_SetWebSubTitle('Message.Pages.Questions.LatestQuestions')
        } else if (to.hash == '#popular') {
          this.tab = 'popular'
          this.$G_SetWebSubTitle('Message.Pages.Questions.RecentlyPopularQuestions')
        } else if (this.$store.getters.App.IsLogin && to.hash == '#following') {
          this.tab = 'following'
          this.$G_SetWebSubTitle('Message.Pages.Questions.QuestionsIAmFollowing')
        }
      }
    }
  },
  watch: {
    '$route'(to, from) {
      this.SwitchWebTitle(to)
    }
  },
  mounted() {
    this.SwitchWebTitle(this.$route)
  },
}
</script>