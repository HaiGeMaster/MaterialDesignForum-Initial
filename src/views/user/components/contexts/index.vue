<template>
	<div>
		<v-card :class="[
			'glass-container',
			'contexts',
			`${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
		]" :outlined="$vuetify.breakpoint.name != 'xs'" :style="{
	'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
	'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
	//'margin-bottom': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
}">
			<Tab :item="HandleTabItem" />
			<v-tabs-items v-model="tab" class="layout-colourless">
				<v-tab-item value="questions">
					<Contexts v-if="tab == 'questions'" :head_title="'Message.Pages.User.Contexts.NAskingQuestions'"
						:head_item="list_header_1" :show_total="true" :type="'questions'" @IsLoading="IsLoading = $event"
						@IsEmpty="IsEmpty = $event" />
				</v-tab-item>
				<v-tab-item value="answers">
					<Contexts v-if="tab == 'answers'" :head_title="'Message.Pages.User.Contexts.NAnswer'" :head_item="list_header_2"
						:show_total="true" :type="'answers'" @IsLoading="IsLoading = $event" @IsEmpty="IsEmpty = $event" />
				</v-tab-item>
				<v-tab-item value="articles">
					<Contexts v-if="tab == 'articles'" :head_title="'Message.Pages.User.Contexts.NArticle'" :head_item="list_header_2"
						:show_total="true" :type="'articles'" @IsLoading="IsLoading = $event" @IsEmpty="IsEmpty = $event" />
				</v-tab-item>
			</v-tabs-items>

		</v-card>
		<Loading v-if="!IsEmpty" :loading="IsLoading" />
	</div>
</template>
<script>
import Tab from '@/components/common/tab/index.vue'
import Contexts from './components/contexts/index.vue'
import Loading from '@/components/loading/index.vue'
export default {
	name: 'page-user-contexts',
	props: {
		user: {
			type: Object,
			default: () => ({
			})
		}
	},
	components: {
		Tab,
		Contexts,
		Loading,
	},
	data: () => ({
		IsLoading: false,
		IsEmpty: false,

		NAskingQuestions: 0,
		NAnswer: 0,
		NArticle: 0,

		tab: 'questions',

		tab_item: [
			{
				text: 'Message.Pages.User.Contexts.TabNAskingQuestions',
				hash: '#questions',
				needLogin: false,
			},
			{
				text: 'Message.Pages.User.Contexts.TabNAnswer',
				hash: '#answers',
				needLogin: false,
			},
			{
				text: 'Message.Pages.User.Contexts.TabNArticle',
				hash: '#articles',
				needLogin: false,
			},
		],
		list_header_1: [
			{
				order: '-update_time',
				name: 'Message.Pages.User.Contexts.UpdateTime_FromLateToEarly',
			},
			{
				order: 'update_time',
				name: 'Message.Pages.User.Contexts.UpdateTime_FromEarlyToLate',
			},
		],
		list_header_2: [
			{
				order: '-create_time',
				name: 'Message.Pages.User.Contexts.ReleaseTime_FromLateToEarly',
			},
			{
				order: 'create_time',
				name: 'Message.Pages.User.Contexts.ReleaseTime_FromEarlyToLate',
			},
			{
				order: '-vote_count',
				name: 'Message.Pages.User.Contexts.MostPopular',
			},
		],
	}),
	methods: {
		OnElementEntryViewport(isEntry) {
			if (this.$route.path != `${this.$G_UrlHeaderLang()}/users`) {
				return
			}
			if (this.IsLoading) {
				return
			}
			if (isEntry) {
				this.IsLoading = true
				//this.GetUserData()
			}
		},
	},
	computed: {
		HandleTabItem() {
			if (this.$route.path.indexOf(`${this.$G_UrlHeaderLang()}/users/`) == -1) {
				return []
			}
			var a = []
			for (let i = 0; i < this.tab_item.length; i++) {
				var texts = this.$t(this.tab_item[i].text)
				//console.log(texts)
				if (this.$route.hash == '#questions' || this.$route.hash == '') {
					this.tab = 'questions'
					texts = texts.replace('%s', this.NAskingQuestions)
				} else if (this.$route.hash == '#answers') {
					this.tab = 'answers'
					texts = texts.replace('%s', this.NAnswer)
				} else if (this.$route.hash == '#articles') {
					this.tab = 'articles'
					texts = texts.replace('%s', this.NArticle)
				}
				//console.log(texts)

				if (this.tab_item[i].needLogin) {
					if (this.$store.getters.App.IsLogin) {
						a.push({
							text: texts,
							hash: this.tab_item[i].hash,
							needLogin: this.tab_item[i].needLogin,
						})
					}
				} else {
					a.push({
						text: texts,
						hash: this.tab_item[i].hash,
						needLogin: this.tab_item[i].needLogin,
					})
				}
			}
			//console.log(a)
			return a
		}
	},
	watch: {
		user(val) {
			this.NAskingQuestions = val.question_count
			this.NAnswer = val.answer_count
			this.NArticle = val.article_count
			//强制更新
			this.$forceUpdate()
		}
	},
}
</script>
<style lang="less"></style>