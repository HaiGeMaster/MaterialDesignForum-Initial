<template>
  <div class="mc-answers-page">
    <ListHeader title="Message.Pages.Question.NAnswers" key="Contexts_4" :item="list_header"
      @OnMenuClickCallback="" />
    <v-card :class="[
      'glass-container',
      'answers',
      `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : 'rounded-0'}`
    ]" outlined
      :style="{
        'border-color': $vuetify.theme.dark ? '#494949' : '#e0e0e0',
        'margin-top': $vuetify.breakpoint.name != 'xs' ? '20px' : '10px',
      }"
    >
      <AnswersItem />
      <v-divider></v-divider>
      <AnswersItem />
    </v-card>
  </div>
</template>
<script>
import AnswersItem from '@/components/answers/components/item/index.vue'
import ListHeader from '@/components/list-header/index.vue'
export default{
  name: 'answers-page',
  components: {
    AnswersItem,
    ListHeader,
  },
  data: () => ({
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
  }),
}
</script>