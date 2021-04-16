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
export default {
  name: "App",
  components: {
    Header
  },
  data() {
    return {
      header: {
        site: {
          name: "warzone-aoe",
          home: '/',
        },
        links: [
          {label: "ホーム", uri: "/"},
          {label: "対戦履歴", uri: "/test"},
          {label: "レーティング", uri: "/test"},
          {label: "Discord", uri: "/test"},
          {label: "問い合わせ", uri: "/test"},
        ]
      }
    }
  },
  mounted() {
    this.$store.dispatch('breakpointStore/updateBreakpoint', {$vuetify: this.$vuetify})
  }
}
</script>