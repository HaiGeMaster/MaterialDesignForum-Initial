<template>
  <v-card 
	:class="[
    'glass-container',
    'contexts',
    `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
  ]"
			:rounded="$vuetify.breakpoint.name != 'xs'" :outlined="$vuetify.breakpoint.name != 'xs'"
			:style="HasFabBtnStyle">
			<Tab :item="tab_item" @OnTabbarClickCallback="OnTabbarClickCallback" />
			<div v-show="(!$store.getters.App.IsLogin && $route.hash == '') ||
				(!$store.getters.App.IsLogin && $route.hash == '#questions') ||
				($store.getters.App.IsLogin && $route.hash == '') ||
				($store.getters.App.IsLogin && $route.hash == '#questions')
				">
				<ListHeader title="Message.Pages.Topic.Contexts.NQuestions" key="Contexts_1" :item="list_header"
					@OnMenuClickCallback="OnMenuClickCallback" />
				<v-divider></v-divider>
				<v-list class="layout-colourless">
					<v-list-item-group>
						<div v-for="folder in 1" :key="'page-topic-recent-folder-' + folder">
							<v-divider :key="'page-topic-recent-divider-' + folder" v-if="folder != 1"></v-divider>
							<ListItem :key="'page-topic-recent-ListItem-' + folder" type='questions'
								:title="'page-topic-questions-' + folder" subtitle="6666666" time="2023-7-5"></ListItem>
						</div>
					</v-list-item-group>
				</v-list>
			</div>
			<div v-show="(!$store.getters.App.IsLogin && $route.hash == '#articles') ||
				($store.getters.App.IsLogin && $route.hash == '#articles')">
				<ListHeader title="Message.Pages.Topic.Contexts.NArticles" key="Contexts_2" :item="list_header"
					@OnMenuClickCallback="OnMenuClickCallback" />
				<v-divider></v-divider>
				<v-list class="layout-colourless">
					<v-list-item-group>
						<div v-for="folder in 2" :key="'page-topic-popular-folder-' + folder">
							<v-divider :key="'page-topic-popular-divider-' + folder" v-if="folder != 1"></v-divider>
							<ListItem :key="'page-topic-popular-ListItem-' + folder" type='articles'
								:title="'page-topic-articles-' + folder" subtitle="6666666" time="2023-7-5"></ListItem>
						</div>
					</v-list-item-group>
				</v-list>
			</div>
			<div
				v-show="$store.getters.App.IsLogin && $route.hash == '#following_questions'">
				<ListHeader title="Message.Pages.Topic.Contexts.NFollowingQuestions" key="Contexts_3" :item="list_header"
					@OnMenuClickCallback="OnMenuClickCallback" />
				<v-divider></v-divider>
				<v-list class="layout-colourless">
					<v-list-item-group>
						<div v-for="folder in 3" :key="'page-topic-following-questions-folder-' + folder">
							<v-divider :key="'page-topic-following-questions-divider-' + folder" v-if="folder != 1"></v-divider>
							<ListItem :key="'page-topic-following-questions-ListItem-' + folder" type='questions'
								:title="'page-topic-following-questions-' + folder" subtitle="6666666" time="2023-7-5">
							</ListItem>
						</div>
					</v-list-item-group>
				</v-list>
			</div>
			<div
				v-show="$store.getters.App.IsLogin && $route.hash == '#following_articles'">
				<ListHeader title="Message.Pages.Topic.Contexts.NFollowingArticles" key="Contexts_4" :item="list_header"
					@OnMenuClickCallback="OnMenuClickCallback" />
				<v-divider></v-divider>
				<v-list class="layout-colourless">
					<v-list-item-group>
						<div v-for="folder in 3" :key="'page-topic-following-articles-folder-' + folder">
							<v-divider :key="'page-topic-following-articles-divider-' + folder" v-if="folder != 1"></v-divider>
							<ListItem :key="'page-topic-following-articles-ListItem-' + folder" type='articles'
								:title="'page-topic-following-articles-' + folder" subtitle="6666666" time="2023-7-5">
							</ListItem>
						</div>
					</v-list-item-group>
				</v-list>
			</div>
		</v-card>
</template>
<script>
import Tab from '@/components/common/tab/index.vue'
import ListItem from '@/components/list-item/index.vue'
import ListHeader from '@/components/list-header/index.vue'
export default {
  name: 'page-topic-contexts',
  components: {
    Tab,
    ListItem,
    ListHeader,
  },
  data: () => ({
    tab_item: [
			{
				text: 'Message.Pages.Topic.Contexts.Questions',
				hash: '#questions',
				needLogin: false,
			},
			{
				text: 'Message.Pages.Topic.Contexts.Articles',
				hash: '#articles',
				needLogin: false,
			},
			{
				text: 'Message.Pages.Topic.Contexts.FollowingQuestions',
				hash: '#following_questions',
				needLogin: true,
			},
			{
				text: 'Message.Pages.Topic.Contexts.FollowingArticles',
				hash: '#following_articles',
				needLogin: true,
			},
		],
		list_header: [
			{
				order: '-update_time',
				name: 'Message.Pages.Topic.Contexts.UpdateTime_FromLateToEarly',
			},
			{
				order: 'update_time',
				name: 'Message.Pages.Topic.Contexts.UpdateTime_FromEarlyToLate',
			},
			{
				order: '-vote_count',
				name: 'Message.Pages.Topic.Contexts.Hottest',
			},
		],
    all_list_header_title: '',
  }),
  methods: {
		OnTabbarClickCallback(text, index) {
			this.all_list_header_title = text
		},
		OnMenuClickCallback(item, order) {
		},
	},
  computed:{
    HasFabBtnStyle() {
      var a = ''
			if (this.$vuetify.breakpoint.name != 'xs') {
				a += 'margin-top: 20px;'
			} else {
				a += 'margin-top: 10px;'
			}
			if (this.$store.getters.App.ShowScrollTopBtn) {
				a += 'margin-bottom: 90px;'
			}
      return a
		}
  }
}
</script>