<template>
  <v-card :class="[
    'new-comment',
    `rounded-${new_comment_rounded_t_or_b}-${$store.getters.App.Style.rounded}`,
    {
      'glass-container':new_comment_need_glass_container,
      'layout-colourless':!new_comment_need_glass_container,
    }
  ]" key="new-comment" v-show="show"
  elevation="0"
  >
    <v-text-field
    :disabled="Submitting"
      :label="$t(label)"
      :loading="Submitting"
      hide-details
      flat
      style="margin-right: 15px;"
      v-model="SubmitText"
      @keydown="$emit('OnStartSubmit',SubmitText)"
      @focus="$emit('OnFocus')"
      @blur="$emit('OnBlur')"
    />
    <v-btn class="submit" color="primary" :disabled="Submitting" @click="Submitting= !Submitting">
      {{Submitting ? $t('Message.Components.Comments.NewComment.Publlishing') : $t('Message.Components.Comments.NewComment.Publish')}}
    </v-btn>
  </v-card>
</template>
<script>
export default{
  name:'comments-new-comment',
  props:{
    show:{
      type:Boolean,
      default:false
    },
    label:{
      type:String,
      default:'Message.Components.Comments.NewComment.WriteYourComment',
    },
    new_comment_need_glass_container:{
      type:Boolean,
      default:true,
    },
    new_comment_rounded_t_or_b:{
      type:String,
      default:'t',
    },
    id:Number,
    type:String,
  },
  data(){
    return{
      SubmitText:'',
      Submitting:false,
    }
  },
}
</script>
<style lang="less">
@import "../../../../vendor/variable.less";
.mc-comments-dialog,
.mc-comments-page {
  .new-comment {
    display: flex;
    align-items: flex-end;
    box-sizing: border-box;
    width: 100%;
    padding-bottom: 16px;
    border-radius-top-left: 10px;
    border-radius-top-right: 10px;
    textarea {
      flex: 1;
      max-height: 60vh;
      margin-right: 16px;
      overflow: auto;
      font-size: inherit;
      border-bottom: none !important;
      box-shadow: 0 1px 0 0 rgba(0,0,0,.42);
      .theme--dark & {
        box-shadow: 0 1px 0 0 rgba(255, 255, 255, .7);
      }
      &:hover,
      &:focus {
        box-shadow: 0 2px 0 0 rgba(0, 0, 0, 0.87);
        .theme--dark & {
          box-shadow: 0 2px 0 0 #fff;
        }
      }
    }
    .submit {
      width: 76px;
    }
  }
}
</style>