<template>
  <v-tooltip bottom :disabled="DeviceTypeMenu">
    <template v-slot:activator="{ on: on1, attrs: attrs1 }">
      <v-menu offset-y v-model="DeviceTypeMenu" :rounded="$store.getters.App.Style.rounded"
      >
        <template v-slot:activator="{ on: on2, attrs: attrs2 }">
          <v-btn icon v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)" v-show="show">
            <v-icon>mdi-devices</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item-group :style="`overflow-y: auto;max-height: 300px;`">
            <v-list-item v-for="(item, i) in DeviceTypeList" :key="`device-type-Button_${i}`"
              :disabled="item.Usability_Rule.indexOf($vuetify.breakpoint.name)== -1"
              @click="SetDeviceType(item.value, true)">
              <v-list-item-title>{{ $t(item.name) }}</v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-menu>
    </template>
    <span>{{
    $t('Message.Components.DeviceTypeButton.SelectDeviceLayout').replace(
      '%s', $t(this.GetDeviceTypeListName($store.getters.App.UserSelectDeviceType))
      )
    }}</span>
  </v-tooltip>
</template>
<script>
export default {
  name: 'device-type-button',
  props:{
    show: {
      Boolean,
      default: true,
    }
  },
  data() {
    return {
      DeviceTypeMenu: false,
      DeviceTypeList: [
        {
          name: 'Message.Components.DeviceTypeButton.Mobile',
          value: 'mobile',
          Usability_Rule:['xs','sm', 'md',],
        },
        {
          name: 'Message.Components.DeviceTypeButton.Pad',
          value: 'pad',
          Usability_Rule:['sm', 'md', 'lg', 'xl'],
        },
        {
          name: 'Message.Components.DeviceTypeButton.Pc',
          value: 'pc',
          Usability_Rule:['lg', 'xl'],
        },
      ],
    }
  },
  methods: {
    SetDeviceType(val) {
      this.$store.getters.App.UserSelectDeviceType = val
    },
    GetDeviceTypeListName(val) {
      for (let i = 0; i < this.DeviceTypeList.length; i++) {
        if (this.DeviceTypeList[i].value == val) {
          return this.DeviceTypeList[i].name
        }
      }
    },
    GetDeviceType() {
      var userAgent = navigator.userAgent.toLowerCase();
      var type = ''
      if (userAgent.match(/mobile/i)) {
        this.$store.getters.App.DeviceType = 'mobile'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.$store.getters.App.UserSelectDeviceType = 'mobile'
        }
        type = 'mobile';
      } else if (userAgent.match(/ipad/i) || userAgent.match(/android/i)) {
        this.$store.getters.App.DeviceType = 'pad'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.$store.getters.App.UserSelectDeviceType = 'pad'
        }
        type = 'pad';
      } else {
        this.$store.getters.App.DeviceType = 'pc'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.$store.getters.App.UserSelectDeviceType = 'pc'
        }
        type = 'pc';
      }
      return type
    },
  },
  watch: {
    '$vuetify.breakpoint.name': {
      handler(val) {
        switch (val) {
          case 'xs':
            this.$store.getters.App.UserSelectDeviceType = 'mobile'
            break
          case 'sm':
          case 'md':
            this.$store.getters.App.UserSelectDeviceType = 'pad'
            break
          case 'lg':
          case 'xl':
            if(this.GetDeviceType()=='pad'){
              this.$store.getters.App.UserSelectDeviceType = 'pad'
            }else{
              this.$store.getters.App.UserSelectDeviceType = 'pc'
            }
            break
        }
      },
      immediate: true,
    },
  }
}
</script>
