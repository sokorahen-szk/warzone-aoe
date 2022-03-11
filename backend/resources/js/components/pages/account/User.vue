<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="right">
      <AccountRightMenu :role="profileView.role" />
    </template>
    <template slot="container">
        <UserTable :items="items" />
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import UserTable from '@organisms/UserTable'
import { profileViewTemplate } from '@/config/account'
import { objCopy } from '@/services/helper'

export default {
  name: 'User',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    UserTable,
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  data() {
    return {
      profileView: profileViewTemplate,
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
}
</script>
