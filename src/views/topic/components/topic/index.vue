<template>
  <v-card :class="[
    'glass-container',
    'topic',
    `${$vuetify.breakpoint.name != 'xs' ? 'rounded-'+$store.getters.App.Style.rounded : $store.getters.App.Style.default_rounded}`
  ]" :rounded="$vuetify.breakpoint.name != 'xs'"
    :style="$vuetify.breakpoint.name != 'xs' ? 'margin-top: 20px;' : 'margin-top: 10px;'">
    <div class="item-info">
      <img class="cover" :src="require('@/assets/images/test.webp')" style="
                width: 100 %;
                        " />
      <div class="main">
        <div class="name">话题标题</div>
        <div class="meta grey--text text--darken-1">
          <span>0 {{ $t('Message.Pages.Topic.Topic.Questions') }}</span>
          <span>0 {{ $t('Message.Pages.Topic.Topic.Articles') }}</span>
        </div>
        <div class="description grey--text text--darken-1">
          话题介绍
        </div>
      </div>
    </div>
    <v-card-actions class="actions">
      <Follow />
      <v-spacer />
      <v-menu offset-y top :rounded="$store.getters.App.Style.rounded">
        <template v-slot:activator="{ attrs, on }">
          <v-btn icon v-bind="attrs" v-on="on" color="grey darken-1">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item link>
            <v-list-item-title>{{ $t('Message.Pages.Topic.Topic.CopyLink') }}</v-list-item-title>
          </v-list-item>
          <v-list-item link>
            <v-list-item-title>{{ $t('Message.Pages.Topic.Topic.Share') }}</v-list-item-title>
          </v-list-item>
          <v-list-item link>
            <v-list-item-title>{{
              $t('Message.Pages.Topic.Topic.LookFollowers').replace('%s', LookFollowersCount)
            }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-card-actions>
  </v-card>
</template>
<script>
import Follow from '@/components/follow/index.vue'
export default {
  name: 'page-topic-topic',
  props: {
    LookFollowersCount: {
      type: Number,
      default: 0,
    }
  },
  components: {
    Follow,
  },
}
</script>
<style lang="less">
@import '../../../../vendor/variable.less';

#page-topic .topic {
  padding: 24px 24px 16px;

  .item-info {
    display: flex;

    .cover {
      width: 180px;
      min-width: 180px;
      height: 101px;
      background-size: contain;
      border-radius: 4px;
    }

    .main {
      padding-left: 24px;
    }

    .name {
      height: 26px;
      font-size: 22px;
    }

    .meta {
      padding-top: 10px;
      font-size: 13px;

      span+span::before {
        margin: 0 8px;
        content: '•';
      }
    }

    .description {
      box-sizing: border-box;
      padding-top: 10px;
      font-size: 14px;
      line-height: 22px;
    }
  }

  .actions {
    display: flex;
    padding-top: 16px;
  }

  @media (max-width: 800px) {
    .item-info {
      .main {
        padding-left: 16px;
      }
    }
  }

  @media (max-width: @screen-xs-max) {
    padding: 16px;
    border-right: none;
    border-left: none;
    border-radius: 0;

    .item-info {
      .cover {
        width: 108px;
        min-width: 108px;
        height: 60px;
      }

      .name {
        padding-top: 2px;
      }

      .meta {
        padding-top: 12px;
      }

      .description {
        margin-top: 8px;
        margin-left: -124px;
      }
    }
  }
}
</style>