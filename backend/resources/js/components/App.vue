<template>
  <v-app id="inspire">
    <Header :header="header" :user="user" />
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import Header from '@/components/organisms/Header';
import { headerConfig } from '@/config/global'
import { userTemplate } from '@/config/user'

export default {
  name: "App",
  components: {
    Header
  },
  data() {
    return {
      header: headerConfig,
      user: userTemplate,
    }
  },
  created() {
    if (this.isLogin) { this.$set(this, 'user', this.getProfile) }
  },
  mounted() {
    this.$store.dispatch('breakpointStore/updateBreakpoint', {$vuetify: this.$vuetify})

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'user', this.getProfile)
      }
    })

  },
  computed: {
        ...mapGetters('accountStore', ['getProfile']),
        ...mapGetters('authStore', ['isLogin']),
  },
}
</script>

<style scoped>
#inspire {
  background: #eee;
}
</style>