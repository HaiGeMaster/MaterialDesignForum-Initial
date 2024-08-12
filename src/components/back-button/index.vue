<template>
  <v-btn text color="primary" :style="$vuetify.breakpoint.name != 'xs' ? 'margin-top: 20px;' : 'margin-top: 10px;'"
    class="glass-container"
    :block="$vuetify.breakpoint.name == 'xs'"
    @click="Back()">
    <v-icon left>
      {{ icon }}
    </v-icon>
    {{ $t(title) }}
  </v-btn>
</template>
<script>
export default {
  name: 'back-button',
  props:{
    title: {
      type: String,
      default: 'Message.Components.Back_Button.Back',
    },
    icon: {
      type: String,
      default: 'mdi-arrow-left'
    }
  },
  methods:{
    Back(){
      if(this.$router.history.current.matched.length == 0){
        let path = this.$router.history.current.path.split('/')
        path.pop()
        path = path.join('/')
        this.$router.push({path: path})
      }else{
        this.$router.go(-1)
      }
    }
  }
}
</script>