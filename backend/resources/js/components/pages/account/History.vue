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
        <GameRecordTable />
      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import GameRecordTable from '@/components/organisms/GameRecordTable'

export default {
  name: 'AccountHistory',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    GameRecordTable,
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
}
</script>