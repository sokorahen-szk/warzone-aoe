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

<Modal
  title="ユーザ編集"
  :show="isShow"
  @update="isShow = $event"
>
  <v-row no-gutters v-if="selectedUser">
    <v-col cols="12" class="py-0 ma-0">
      <v-row no-gutters>
        <v-col cols="6">
          <v-col cols="12" class="py-0 ma-0">
              <div>ユーザID</div>
              <div class="mb-4">{{selectedUser.id}}</div>
          </v-col>
          <v-col cols="12" class="py-0 ma-0">
              <div>アカウント作成日</div>
              <div class="mb-4">{{selectedUser.player.joinedAt}}</div>
          </v-col>
          <v-col cols="12" class="py-0 ma-0">
              <div>最終ゲーム参加日</div>
              <div class="mb-4">{{selectedUser.player.lastGameAt}}</div>
          </v-col>
        </v-col>
        <v-col cols="6" class="text-center">
          <Avator
            size="200"
            :src="selectedUser.avatorImage"
          />
        </v-col>
      </v-row>
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>ユーザ名</div>
      <TextInput
        v-model="selectedUser.name"
        @update="selectedUser.name = $event"
        placeholder=""
        outlined
        required
        :rules="{label:'ユーザ名', types:'required,min:4,max:10'}"
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>メールアドレス</div>
      <TextInput
        v-model="selectedUser.email"
        @update="selectedUser.email = $event"
        placeholder=""
        outlined
        required
        :rules="{label:'email', types:''}"
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>ステータス</div>
      <SelectBox
        value="1"
        :rules="{label:'ステータス', types:'required'}"
        :items="setUserStatuses"
        :selectedIndex="selectedUser.status"
        @input="selectedUser.status = $event"
        :disabled="setUserStatuses.length < 1"
        placeholder="ステータスを選択する"
        required
        outlined
        dense
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>ロール</div>
      <SelectBox
        value="1"
        :rules="{label:'ロール', types:'required'}"
        :items="setRoles"
        :selectedIndex="selectedUser.role.id"
        @input="selectedUser.role.id = $event"
        :disabled="setRoles.length < 1"
        placeholder="ロールを選択する"
        required
        outlined
        dense
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>SteamID</div>
      <TextInput
        v-model="selectedUser.steamId"
        @update="selectedUser.steamId = $event"
        placeholder=""
        outlined
        required
        :rules="{label:'steamID', types:''}"
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>Twitter</div>
      <TextInput
        v-model="selectedUser.twitterId"
        @update="selectedUser.twitterId = $event"
        placeholder=""
        outlined
        required
        :rules="{label:'twitterId', types:''}"
      />
    </v-col>
    <v-col cols="12" class="py-0 ma-0">
      <div>Webサイト</div>
      <TextInput
        v-model="selectedUser.webSiteUrl"
        @update="selectedUser.webSiteUrl = $event"
        placeholder=""
        outlined
        required
        :rules="{label:'Webサイト', types:''}"
      />
    </v-col>
  </v-row>
</Modal>

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
import Modal from '@atoms/Modal'
import TextInput from '@atoms/TextInput'
import SelectBox from '@atoms/SelectBox'
import Avator from '@atoms/Avator'
import { profileViewTemplate } from '@/config/account'
import { alertTemplate } from '@/config/global'
import { objCopy } from '@/services/helper'
import { userStatusLabels } from '@/config/user'
import { roles } from '@/config/admin'

export default {
  name: 'User',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    UserTable,
    Alert,
    Button,
    Modal,
    TextInput,
    SelectBox,
    Avator,
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
    ...mapGetters('adminStore', ['getUsers', 'getUsersTotalPage']),

    setUserStatuses() {
      let v = []
      userStatusLabels.forEach( (item) => {
        v.push({
          label: item.label,
          value: item.id,
        })
      })

      return v
    },
    setRoles() {
      let v = []
      roles.forEach( (item) => {
        v.push({
          label: item.label,
          value: item.id,
        })
      })

      return v
    },
  },
  data() {
    return {
      profileView: profileViewTemplate,
      users: null,
      selectedUser: null,
      alert: alertTemplate,
      isShow: false,
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
      const findUser = this.findUserById(id)

      if (!findUser) {
        return
      }

      this.isShow = true

      this.$set(this, 'selectedUser', findUser)
    },
    findUserById(id) {
      return  this.users.find( (user) => user.id === id )
    },
  }
}
</script>
