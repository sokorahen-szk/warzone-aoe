<template>
  <v-app id="inspire">
    <Header :header="header" />
    <v-main>
      <router-view />
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

<style scoped>
#inspire {
  background: #eee;
}
</style>