<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="header">
      <Alert :properties="alert" dense />
    </template>
    <template slot="right">
      <AccountRightMenu :role="profileView.role" />
    </template>
    <template slot="container">
      <v-container>

        <AdminPlayerTable :players="players"/>

      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import AdminPlayerTable from '@organisms/AdminPlayerTable'
import Alert from '@atoms/Alert'
import { mapActions, mapGetters } from 'vuex'
import { objCopy } from '@/services/helper'
import { alertTemplate } from '@/config/global'
import { profileViewTemplate } from '@/config/account'

export default {
  name: 'Rate',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    Alert,
    AdminPlayerTable,
  },
  data() {
    return {
      profileView: profileViewTemplate,
      alert: alertTemplate,

      // TODO: テストデータ
      players: [
        {
          id: 1,
          name: 'test',
          avatorImage: null,
          rank: 25,
          sigma: 25.22,
          rate: 2500,
          enabled: true,
        },
        {
          id: 2,
          name: 'nagisa',
          avatorImage: null,
          rank: 25,
          sigma: 25.22,
          rate: 2500,
          enabled: true,
        },
      ]

    }
  },
  mounted() {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
    })
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
}
</script>
