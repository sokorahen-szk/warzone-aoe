<template>
  <v-app id="inspire">
    <Header :header="header" />
    <v-main>
      <v-container>
      <router-view />
      </v-container>
    </v-main>
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
      header: headerConfig,
    }
  },
  mounted() {
    this.$store.dispatch('breakpointStore/updateBreakpoint', {$vuetify: this.$vuetify})
  }
}
</script>