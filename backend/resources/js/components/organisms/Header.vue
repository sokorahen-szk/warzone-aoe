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
      <Avatar class="ml-2" :src="user.image" :alt="user.name" :size="36" />
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
        <Avatar class="mb-2" :src="user.image" :alt="user.name" />
        <div>{{user.name}}</div>
      </v-sheet>

    </v-navigation-drawer>

  </header>
</template>

<script>
import { mapGetters } from 'vuex'
import Avatar from '@/components/molecules/Avatar'

export default {
  name: "Header",
  props: {
    header: {type: Object, required: true},
  },
  components: {
    Avatar
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    device() {
      return this.getDeviceType;
    }
  },
  data() {
    return {
      drawer: false,
      user: {
        name: "たろう",
        image: 'https://p4.wallpaperbetter.com/wallpaper/905/958/530/touwa-erio-anime-wallpaper-preview.jpg',
      }
    }
  }
}
</script>
