<template>
  <v-tooltip bottom :disabled="DeviceTypeMenu">
    <template v-slot:activator="{ on: on1, attrs: attrs1 }">
      <v-menu offset-y v-model="DeviceTypeMenu" :rounded="$store.getters.App.Style.rounded">
        <template v-slot:activator="{ on: on2, attrs: attrs2 }">
          <v-btn icon v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)" v-show="show">
            <v-icon>
              {{ GetDeviceIcon($store.getters.App.UserSelectDeviceType) }}
            </v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-list>
            <v-list-item-group :style="`overflow-y: auto;max-height: 300px;`">
              <v-list-item v-for="(item, i) in DeviceTypeList" :key="`device-type-Button_${i}`"
                :class="$store.getters.App.UserSelectDeviceType == item.value?'v-item--active v-list-item--active':''"
                :disabled="item.Usability_Rule.indexOf($vuetify.breakpoint.name||'xs')== -1"
                @click="SetDeviceType(item.value, true)">
                <v-list-item-icon>
                  <v-icon >{{ GetDeviceIcon(item.value) }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title
                  >{{ $t(item.name) }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
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
          Usability_Rule: ['xs', 'sm', 'md'],
          //Usability_Rule: ['xs', 'sm', 'md'],
        },
        {
          name: 'Message.Components.DeviceTypeButton.Pad',
          value: 'pad',
          Usability_Rule: ['sm', 'md', 'lg', 'xl'],
        },
        {
          name: 'Message.Components.DeviceTypeButton.Pc',
          value: 'pc',
          Usability_Rule: ['lg', 'xl'],
          //Usability_Rule: ['xs', 'sm','lg', 'xl'],
        },
      ],
    }
  },
  methods: {
    SetDeviceType(val) {
      document.getElementById('app').className = document.getElementById('app').className.replace(/(mobile|pad|pc)/g, '').trim() + ' ' + val
      if (val == 'mobile') {
        if (this.$store.getters.App.Drawer.Show) {
        }
      } else if (val == 'pad') {
        if (!this.$store.getters.App.Drawer.Show) {
          this.$store.getters.App.Drawer.Show = true
        }
      } else if (val == 'pc') {
        if (!this.$store.getters.App.Drawer.Show) {
          this.$store.getters.App.Drawer.Show = true
        }
      }
      this.$store.getters.App.UserSelectDeviceType = val
    },
    GetDeviceTypeListName(val) {
      for (let i = 0; i < this.DeviceTypeList.length; i++) {
        if (this.DeviceTypeList[i].value == val) {
          return this.DeviceTypeList[i].name
        }
      }
    },
    GetDeviceIcon(val){
      if (val == 'mobile') {
        return 'mdi-cellphone'
      } else if (val == 'pad') {
        return 'mdi-tablet'
      } else if (val == 'pc') {
        if(this.$vuetify.breakpoint.name=='xl'){
          return 'mdi-monitor'
        }else{
          return 'mdi-laptop'
        }
      }
    },
    GetDeviceType() {
      var userAgent = navigator.userAgent.toLowerCase();
      var type = ''
      if (userAgent.match(/mobile/i)) {
        this.$store.getters.App.DeviceType = 'mobile'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.SetDeviceType('mobile')
        }
        type = 'mobile';
      } else if (userAgent.match(/ipad/i) || userAgent.match(/android/i)) {
        this.$store.getters.App.DeviceType = 'pad'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.SetDeviceType('pad')
        }
        type = 'pad';
      } else {
        this.$store.getters.App.DeviceType = 'pc'
        if (this.$store.getters.App.UserSelectDeviceType == '') {
          this.SetDeviceType('pc')
        }
        type = 'pc';
      }
      return type
    },
    UpdateDeviceType(val) {
      var a = ''
        switch (val) {
          case 'xs':
            a = 'mobile'
            break
          case 'sm':
          case 'md':
            a = 'pad'
            break
          case 'lg':
          case 'xl':
            if (this.GetDeviceType() == 'pad') {
              a = 'pad'
            } else {
              a = 'pc'
            }
            break
        }
      this.SetDeviceType(a)
    }
  },
  watch: {
    '$vuetify.breakpoint.name': function (val) {
      this.UpdateDeviceType(val)
    }
  },
  mounted() {
    this.UpdateDeviceType(this.$vuetify.breakpoint.name)
    if (!this.$store.getters.App.Drawer.Show && this.$store.getters.App.UserSelectDeviceType == 'pad') {
      this.$store.getters.App.Drawer.Show = true
    }
  }
}
</script>
