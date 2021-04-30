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
import ListWithSubHeader from '@/components/molecules/ListWithSubHeader'
import Button from '@/components/atoms/Button'
import { rightMenuCommonList, rightMenuOtherList } from '@/config/account'
import router from '@/router/index'
export default {
  name: 'AccountRightMenu',
  components: {
    ListWithSubHeader,
    Button,
  },
  data() {
    return {
      rightMenuCommon: rightMenuCommonList,
      rightMenuOther: rightMenuOtherList,
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