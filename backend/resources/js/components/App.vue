<template>
  <v-app>
    <Header :header="header"/>
    <v-container>
     <router-view />
    </v-container>
  </v-app>
</template>

<script>
import Header from '@/components/organisms/Header';
import { headerConfig } from '@/config/global'

export default {
  name: "App",
  components: {
    Header
  },
  data() {
    return {
      header: headerConfig
    }
  },
  mounted() {
    this.$store.dispatch('breakpointStore/updateBreakpoint', {$vuetify: this.$vuetify})
  }
}
</script>