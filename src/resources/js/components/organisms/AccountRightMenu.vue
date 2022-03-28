<template>
  <v-container>
    <ListWithSubHeader
      :sub-header="rightMenuCommon.subHeader"
      :lists="rightMenuCommon.lists"
    />
    <ListWithSubHeader
      :sub-header="rightMenuOther.subHeader"
      :lists="rightMenuOther.lists"
    />
    <ListWithSubHeader
      v-if="['owner', 'administrator', 'moderator'].indexOf(role.name) !== -1"
      :sub-header="rightMenuModeleter.subHeader"
      :lists="rightMenuModeleter.lists"
    />
    <ListWithSubHeader
      v-if="['owner', 'administrator'].indexOf(role.name) !== -1"
      :sub-header="rightMenuAdmin.subHeader"
      :lists="rightMenuAdmin.lists"
    />
    <Button
      class="my-2"
      label="ログアウト"
      text
      @click="logoutEvent"
    />
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import ListWithSubHeader from '@molecules/ListWithSubHeader'
import Button from '@atoms/Button'
import {
  rightMenuCommonList,
  rightMenuOtherList,
  rightMenuModeleterList,
  rightMenuAdminList
} from '@/config/account'
import router from '@/router/index'
export default {
  name: 'AccountRightMenu',
  components: {
    ListWithSubHeader,
    Button,
  },
  props: {
    role: {type: Object},
  },
  data() {
    return {
      rightMenuCommon: rightMenuCommonList,
      rightMenuOther: rightMenuOtherList,
      rightMenuModeleter: rightMenuModeleterList,
      rightMenuAdmin: rightMenuAdminList,
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