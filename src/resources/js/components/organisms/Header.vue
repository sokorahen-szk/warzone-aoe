<template>
  <header>
    <v-app-bar dense color="#424242" app>
      <v-container class="py-0 fill-height container">
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

      <template v-if="getDeviceType == 'pc'">
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
        <Link :path="homePath">
          <Avatar class="ml-4" :src="user.avatorImage" :alt="user.name" :size="34" />
        </Link>
        </template>
        <template v-else>
        <Button class="mr-2" label="ログイン" path="/login" color="primary" icon-type="mdi-login" icon />
        <Button label="新規登録" path="/register" color="success" icon-type="mdi-account" icon />
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
      v-if="getDeviceType == 'sp'"
      v-model="drawer"
      app
      right
    >
      <v-sheet
        v-if="isLogin"
        color="grey lighten-4"
        class="pa-3"
      >
        <Link :path="homePath">
          <Avatar class="mb-2" :src="user.avatorImage" :alt="user.name" />
        </Link>
        <v-row no-gutters>
          {{user.name}}
        </v-row>
      </v-sheet>
      <div class="pa-1" v-else>
        <Button class="mb-1" label="ログイン" path="/login" color="primary" icon-type="mdi-login" icon block tile />
        <Button label="新規登録" path="/register" color="success" icon-type="mdi-account" icon block tile />
      </div>

    <v-list dense class="pa-0 ma-0">
      <template v-for="(list, index) in mobileMenuLists">
        <template v-if="!list.subLists">
        <v-list-item :key="`mobile-menu-list-${index}`" :to="list.path">
          <v-list-item-icon v-if="list.icon">
            <Icon :size="26">{{list.icon}}</Icon>
          </v-list-item-icon>
          <v-list-item-title>
            {{list.label}}
          </v-list-item-title>
        </v-list-item>
        <v-divider :key="`mobile-menu-list-border-${index}`" />
        </template>
        <template v-else>
          <template v-if="isLogin">
          <v-list-group
            :key="`mobile-menu-list-group-${index}`"
            :prepend-icon="list.icon"
          >
            <template v-slot:activator>
              <v-list-item-title>{{list.label}}</v-list-item-title>
            </template>
            <v-list-item
              v-for="(sublist, idx) in list.subLists"
              :key="`mobile-menu-list-group-sub-${idx}`"
              :to="sublist.path"
            >
              <v-list-item-title>
                {{sublist.label}}
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="logoutEvent">
              <v-list-item-title>
                ログアウト
              </v-list-item-title>
            </v-list-item>
          </v-list-group>
          </template>
        </template>
      </template>
    </v-list>
    </v-navigation-drawer>

  </header>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Avatar from '@molecules/Avatar'
import Button from '@atoms/Button'
import Icon from '@atoms/Icon'
import Link from '@atoms/Link'
import ComponentTemplate from '@/components/ComponentTemplate'
import { mobileMenuLists } from '@/config/global'
import router from '@/router/index'
export default {
  name: "Header",
  props: {
    header: {type: Object, required: true},
    user: {type: Object},
  },
  components: {
    Avatar,
    Button,
    Link,
    Icon
  },
  extends: ComponentTemplate,
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    ...mapGetters('authStore', ['isLogin']),
  },
  data() {
    return {
      drawer: false,
      homePath: '/account/mypage',
      mobileMenuLists: mobileMenuLists,
    }
  },
  methods: {
    ...mapActions('authStore', ['logout']),
    logoutEvent() {
      new Promise( resolve => {
        resolve(this.logout())
      })
      .then( () => {
        router.push({path: '/'})
      })
    }
  }
}
</script>