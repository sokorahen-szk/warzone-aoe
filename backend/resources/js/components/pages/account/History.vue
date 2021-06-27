<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="right">
      <AccountRightMenu />
    </template>
    <template slot="container">
      <v-container>
        ここに対戦履歴テーブル
      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
export default {
  name: 'AccountHistory',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
}
</script>