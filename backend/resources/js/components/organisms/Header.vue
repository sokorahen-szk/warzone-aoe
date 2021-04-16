<template>
  <header>
    <v-app-bar flat dense color="#424242">
      <v-container class="py-0 fill-height">
      <v-toolbar-title>
        <v-btn
         :to="header.site.home"
         text
         plain
         color="#ffffff"
        >
          {{header.site.name}}
        </v-btn>
      </v-toolbar-title>
      <v-spacer />

      <template v-if="device == 'pc'">
      <v-btn
        v-for="link in header.links"
        :key="link.label"
        :to="link.uri"
        text
        plain
        color="#ffffff"
      >
        {{ link.label }}
      </v-btn>
      </template>
      <template v-else>
      <v-app-bar-nav-icon large color="#ffffff" />
      </template>

      </v-container>
    </v-app-bar>
  </header>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: "Header",
  props: {
    header: {type: Object, required: true},
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    device() {
      return this.getDeviceType;
    }
  },
  data() {
    return {
      //
    }
  },
}
</script>
