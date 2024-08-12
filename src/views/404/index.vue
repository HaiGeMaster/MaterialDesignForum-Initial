<template>
  <v-container class="glass-container" style="height: 999px;padding-bottom: 50%;max-width: 800px;">
    <div style="text-align: center;margin-top: 50%;">
      <img :src="require('@/assets/images/test.webp')"/>
      <h1 style="color: gray;size: 300px;">{{$t('Message.Pages.PageNotFound.Page404')}}</h1>
      <v-btn :to="`${$G_UrlHeaderLang()}/`" color="primary">{{$t('Message.Pages.PageNotFound.BackToHome')}}</v-btn>
    </div>
  </v-container>
</template>
<script>
export default {
  name: 'page-404',
  data: () => ({
  }),
  methods: {
  },
}