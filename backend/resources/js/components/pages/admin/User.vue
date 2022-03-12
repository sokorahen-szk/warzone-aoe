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
        <UserTable
          :users="users"
          :userRecordTotalPage="getUsersTotalPage"
          :current-page="page"
          @changePage="(currentPage) => page = currentPage"
          @clickShow="show"
        >
        <template v-slot:header>
          <v-row no-gutters>
            <v-col class="text-right">
              <Button
                color="success"
                label="新規登録"
                @click="create"
              />
            </v-col>
          </v-row>
        </template>
        </UserTable>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import UserTable from '@organisms/UserTable'
import Alert from '@atoms/Alert'
import Button from '@atoms/Button'
import { profileViewTemplate } from '@/config/account'
import { alertTemplate } from '@/config/global'
import { objCopy } from '@/services/helper'

export default {
  name: 'User',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    UserTable,
    Alert,
    Button,
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
    ...mapGetters('adminStore', ['getUsers', 'getUsersTotalPage']),
  },
  data() {
    return {
      profileView: profileViewTemplate,
      users: null,
      alert: alertTemplate,

      userRecordTotalPage: 0,
      page: 1,
    }
  },
  watch: {
    page() {
      this.fetchList()
    },
  },
  mounted() {
    this.fetchList()

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
      if (mutation.type === 'adminStore/setUsers') {
        this.$set(this, 'users', this.getUsers)
        this.$set(this, 'userRecordTotalPage', this.getUsersTotalPage)
      }
    })
    this.$set(this, 'users', this.getUsers)
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  },
  methods: {
    ...mapActions('adminStore', ['userList']),
    fetchList() {

      this.users = null

      new Promise((resolve) => {
        resolve(this.userList({page: this.page}))
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
    },
    create() {
      // TODO:
      console.log('create')
    },
    show(id) {
       console.log(id)
      console.log('show')
    }
  }
}
</script>
