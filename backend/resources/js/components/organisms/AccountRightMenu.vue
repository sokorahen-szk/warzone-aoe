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
      @click="logout"
    />
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import ListWithSubHeader from '@/components/molecules/ListWithSubHeader'
import Button from '@/components/atoms/Button'
import { rightMenuCommonList, rightMenuOtherList } from '@/config/account'
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
  }
}
</script>