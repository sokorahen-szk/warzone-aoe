<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="right">
      <AccountRightMenu :role="profileView.role" />
    </template>
    <template slot="container">
      <v-row no-gutters>
        <v-col cols="12">
          <div class="py-2">退会手続き</div>
          <div class="text-center">
            <v-icon size="64" color="red">mdi-alert</v-icon>
          </div>
          <div class="text-center py-2">
            退会手続きの前にご確認ください
          </div>
          <v-row no-gutters justify="center" align-content="center" style="height: 75px;">
            <CheckBoxList
              :items="question"
              @update="valid = !valid"
            />
          </v-row>
          <div class="text-center mb-4">
            <Button
              width="150"
              height="45"
              color="error"
              label="退会する"
              @click="withdrawalEvent"
              :disabled="!valid"
            ></Button>
          </div>
        </v-col>
      </v-row>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import Button from '@atoms/Button'
import CheckBoxList from '@molecules/CheckBoxList'
import router from '@/router/index'
import { profileViewTemplate } from '@/config/account'
import { objCopy } from '@/services/helper'

export default {
  name: 'Withdrawal',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    Button,
    CheckBoxList
  },
  data() {
    return {
      profileView: profileViewTemplate,
      valid: false,
      question: [{selected: false, label: "アカウントを停止することに同意する", value: true}],
    }
  },
  methods: {
    ...mapActions('accountStore', ['withdrawal']),
    withdrawalEvent() {
      new Promise((resolve) => {
        resolve(this.withdrawal())
      })
      .then( (res) => {
        // TODO: ここはモーダルにするはず
        alert(res);
        router.push({path: '/'})
      })
      .catch( (err) => {
        // TODO: ここはモーダルにするはず
        alert(err);
      })
    }
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
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