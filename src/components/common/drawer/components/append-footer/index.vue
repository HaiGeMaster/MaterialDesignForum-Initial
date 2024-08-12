<template>
  <div class="copyright">
    <v-menu :close-on-content-click="false" :nudge-width="200" offset-x :rounded="$store.getters.App.Style.rounded">
      <template v-slot:activator="{ on: on1, attrs: attrs1 }">
        <v-tooltip right>
          <template v-slot:activator="{ on: on2, attrs: attrs2 }">
            <v-btn icon class="about-btn" v-bind="Object.assign({}, attrs1, attrs2)" v-on="Object.assign({}, on1, on2)"
              style="margin: auto;">
              <v-icon>mdi-information-outline</v-icon>
            </v-btn>
          </template>
          <span>{{ $t('Message.Components.Common.Drawer.AppendFooter.InformationAboutThisSite') }}</span>
        </v-tooltip>
      </template>
      <v-card>
        <v-card-title class="text-h5">
          {{ $t('Message.Components.Common.Drawer.AppendFooter.InformationAboutThisSite') }}
        </v-card-title>
        <v-card-text>
          <div class="copyright-div-menu">
            <Copyright />
          </div>
        </v-card-text>
      </v-card>
    </v-menu>
    <div class="copyright-div layout-colourless">
      <Copyright />
    </div>
  </div>
</template>
<script>
import Copyright from "./components/copyright"
export default {
  name: "drawer-append-footer",
  components: {
    Copyright,
  },
  data() {
    return {
      dialog: false,
    }
  },
}
</script>
<style lang="less">
.copyright {
  box-sizing: border-box;
  width: 100%;
  padding: 20px 16px;

  .v-list-centered & {
    //padding: 8px 8px;
    padding: 0;
  }

  .copyright-div {
    .v-list-centered & {
      display: none;
    }

    .v-navigation-drawer--bottom & {
      display: flex;
      flex-direction: column;
      align-items: center;

      .copyright-components {
      display: flex;
      flex-direction: column;
      align-items: center;
      }
    }
  }

  .about-btn {
    width: 86px;
    height: 86px;
    display: none;

    .v-list-centered & {
      display: block;
    }
  }

  p {
    margin: 0;
    overflow: hidden;
    color: rgba(0, 0, 0, 0.38) !important;
    font-size: 13px;
    line-height: 20px;
    white-space: nowrap;
    text-overflow: ellipsis;

    .theme--dark & {
      color: rgba(255, 255, 255, .38) !important;
    }
  }

  a {
    padding: 2px;
    font-size: 13px;
    color: rgba(0, 0, 0, 0.52) !important;
    text-decoration: none;

    .theme--dark & {
      color: rgba(255, 255, 255, .52) !important;
    }

    &:hover {
      text-decoration: underline;
    }

    img{
      width: 16px;
      height: 16px;
      margin-right: 4px;
      float:left;
    }
  }
}

.copyright-div-menu {
  .copyright-components {
    p {
      margin: 0;
      overflow: hidden;
      color: rgba(0, 0, 0, 0.38) !important;
      font-size: 13px;
      line-height: 20px;
      white-space: nowrap;
      text-overflow: ellipsis;

      .theme--dark & {
        color: rgba(255, 255, 255, .38) !important;
      }
    }

    a {
      color: rgba(0, 0, 0, 0.52) !important;
      text-decoration: none;

      .theme--dark & {
        color: rgba(255, 255, 255, .52) !important;
      }

      &:hover {
        text-decoration: underline;
      }
    }
  }

}
</style>