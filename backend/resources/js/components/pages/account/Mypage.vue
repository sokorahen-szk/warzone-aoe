<template>
  <CommonWithRightColumnTransportTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="right">
      <AccountRightMenu />
    </template>
    <template slot="container">
      <v-card
        class="pa-3 mb-4"
        tile
        outlined
      >
      <v-row no-gutters>
        <v-col cols="12">
          <div class="py-2">ステータス</div>
          <v-divider />
          <v-row no-gutters class="pt-2">
            <v-col cols="6">
              <div>アカウント状態</div>
              <TextMark
                :value="profileView.status"
                color="light-green"
              />
            </v-col>
            <v-col cols="6">
              <div>プレイヤー状態</div>
              <Status :value="profileView.player.enabled" />
            </v-col>
            <v-col cols="6">
              <div>ロール</div>
              {{ profileView.role.name }}
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      </v-card>

      <v-card
        class="pa-3 mb-4"
        tile
        outlined
      >
        <v-row no-gutters>
          <v-col cols="12">
            <div class="py-2">自分が建てたゲーム</div>
            <v-row no-gutters no-wrap class="blue-grey lighten-5 py-1">
              <v-col cols="3">ゲームID</v-col>
              <v-col cols="3">マップ</v-col>
              <v-col cols="3">ルール</v-col>
              <v-col cols="3">プレイヤー</v-col>
            </v-row>
            <v-row no-gutters no-wrap class="py-3">
              <v-col cols="3">1100</v-col>
              <v-col cols="3">アラビア</v-col>
              <v-col cols="3">ESUDAルール</v-col>
              <v-col cols="3">8 人</v-col>
            </v-row>
            <v-row no-gutters no-wrap class="py-1">
              <v-col cols="6" class="blue-grey lighten-5">開始時間</v-col>
              <v-col cols="6">2021-11-10 00:00:00</v-col>
            </v-row>
            <v-row no-gutters class="py-3">
              <v-col cols="12" class="text-center">
                <Button color="info" label="チーム1勝利" depressed/>
                <Button color="info" label="チーム2勝利" depressed/>
                <Button color="warning" label="引き分け" depressed/>
                <Button color="error" label="取り消し" depressed/>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </template>
  </CommonWithRightColumnTransportTemplate>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTransportTemplate from '@templates/CommonWithRightColumnTransportTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import TextMark from '@atoms/TextMark'
import Status from '@atoms/Status'
import Button from '@atoms/Button'
import {objCopy} from '@/services/helper'
import { profileViewTemplate } from '@/config/account'

export default {
  name: 'AccountMypage',
  components: {
    CommonWithRightColumnTransportTemplate,
    AccountRightMenu,
    TextMark,
    Status,
    Button,
  },
  data() {
    return {
      profileView: profileViewTemplate
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
