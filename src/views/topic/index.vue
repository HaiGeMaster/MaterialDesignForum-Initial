<template>
	<v-container id="page-topic"
		:style="$vuetify.breakpoint.name != 'xs' ? 'max-width: 830px;padding:0 12px;' : 'max-width: 830px;padding:0 0px;'">
		<BackButton/>
		<Topic />
		<Context />
		<Loading :loading="IsLoading"/>
		<!-- <MdEditor/> -->
	</v-container>
</template>
<script>
import BackButton from '@/components/back-button/index.vue'
import Topic from './components/topic/index.vue'
import Context from './components/contexts/index.vue'
import Loading from '@/components/loading/index.vue'
//import MdEditor from '@/components/md-editor/index.vue'
export default {
	name: 'page-topic',
	data: () => ({
    IsLoading: false,
	}),
	components: {
		BackButton,
		Context,
		Topic,
		Loading,
		//MdEditor,
	},
}
</script>
<style lang="less">
@import '../../vendor/variable.less';
#page-topic .contexts,
#page-user .contexts {
	margin-top: 16px;
	.mc-list-header {
		padding: 16px;
		.title {
			font-size: 16px;
		}
		button {
			padding-right: 0;
		}
	}
	@media (max-width: @screen-xs-max) {
		border-right: none;
		border-left: none;
		border-radius: 0;
		.mc-list-header {
			.title {
				font-size: 15px;
			}
		}
	}
}
</style>