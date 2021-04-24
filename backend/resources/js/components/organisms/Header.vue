<template>
  <header>
    <v-app-bar flat dense color="#424242" app>
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

        <template v-if="isLogin">
        <Link path="/account/dashboard">
          <Avatar class="ml-4" :src="user.avatorImage" :alt="user.name" :size="34" />
        </Link>
        </template>
        <template v-else>
        <Button class="mr-2" label="ログイン" path="/login" color="primary" icon-type="mdi-login" icon />
        <Button label="新規登録" path="/passowrd/reset" color="success" icon-type="mdi-account" icon />
        </template>

      </template>
      <template v-else>
      <v-app-bar-nav-icon
        large
        color="#ffffff"
        @click="drawer = !drawer"
      />
      </template>

      </v-container>

    </v-app-bar>

    <v-navigation-drawer
      v-if="device == 'sp'"
      v-model="drawer"
      app
      right
    >
      <v-sheet
        color="grey lighten-4"
        class="pa-3"
      >
        <Avatar class="mb-2" :src="user.avatorImage" :alt="user.name" />
        <div>{{user.name}}</div>
      </v-sheet>

    </v-navigation-drawer>

  </header>
</template>

<script>
import { mapGetters } from 'vuex'
import Avatar from '@/components/molecules/Avatar'
import Button from '@/components/atoms/Button'
import Link from '@/components/atoms/Link'
export default {
  name: "Header",
  props: {
    header: {type: Object, required: true},
    user: {type: Object},
  },
  components: {
    Avatar,
    Button,
    Link
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    ...mapGetters('authStore', ['isLogin']),
    device() {
      return this.getDeviceType;
    }
  },
  data() {
    return {
      drawer: false,
    }
  }
}
</script>
