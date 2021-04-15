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
          {label: "Home", uri: "/"},
          {label: "Test", uri: "/test"},
        ]
      }
    }
  }
}
</script>