<template>
  <CommonWithRightColumnTransportTemplate
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
              <div>ユーザ状態</div>
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
      <div class="pt-4">
        <Alert
          :dismissible="false"
          :properties="emailNotRegisteredAlert"
          :auto-closed="false"
          v-if="!profileView.email"
          dense
        ></Alert>
      </div>
      </v-card>
      <v-card
        class="pa-3 mb-4"
        tile
        outlined
        v-if="myGameRecords.length > 0"
      >
        <v-row no-gutters>
          <v-col cols="12">
            <div class="py-2">自分が建てたゲーム</div>
            <v-divider />
            <div v-for="myGameRecord in myGameRecords" :key="`my-game-record-id-${myGameRecord.gameRecordId}`">
              <v-row no-gutters class="pt-2">
                <v-col cols="12" sm="6" md="12" lg="6" xl="6" class="text-center">
                  <Img
                    :src="myGameRecord.gameMap.imagePath"
                    width="240"
                    height="180"
                  />
                  <div class="py-1">
                    {{myGameRecord.gameMap.name}}
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="12" lg="6" xl="6">
                  <v-row no-gutters>
                    <v-col cols="12" class="blue-grey lighten-5 py-1">ゲームID</v-col>
                    <v-col cols="12" class="py-1">
                      {{myGameRecord.gameRecordId}}
                    </v-col>
                    <v-col cols="12" class="blue-grey lighten-5 py-1">ルール</v-col>
                    <v-col cols="12" class="py-1">
                      {{myGameRecord.gameRule.name}}
                    </v-col>
                    <v-col cols="12" class="blue-grey lighten-5 py-1">プレイヤー</v-col>
                    <v-col cols="12" class="py-1">
                      {{myGameRecord.playerCount}} 人
                    </v-col>
                    <v-col cols="12" class="blue-grey lighten-5 py-1">開始時間</v-col>
                    <v-col cols="12" class="py-1">
                      {{myGameRecord.startedAt}}
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>

              <v-row no-gutters class="py-3">
                <v-col cols="12" class="text-center">
                  <Button
                    v-for="t in gameWarsChangeStatusButtons"
                    class="ml-2"
                    :disabled="isGameStatusUpdateButtonDisabled"
                    :color="t.color"
                    :label="t.label"
                    :key="t.label"
                    @click="updateGameRecord(t.label, myGameRecord.gameRecordId, t.game_status, t.winningTeam)"
                    depressed
                  />
                </v-col>
              </v-row>
            </div>
          </v-col>
        </v-row>
      </v-card>
      <v-card
        class="pa-3 mb-4"
        tile
        outlined
        v-else
      >
        <Loading
          size="64"
          v-if="myGameRecordLoading"
        />
        <div v-else>
          現在、建てた部屋がありません。
        </div>
      </v-card>
    </template>
  </CommonWithRightColumnTransportTemplate>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CommonWithRightColumnTransportTemplate from '@templates/CommonWithRightColumnTransportTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import TextMark from '@atoms/TextMark'
import Status from '@atoms/Status'
import Button from '@atoms/Button'
import Img from '@atoms/Img'
import Loading from '@atoms/Loading'
import Alert from '@atoms/Alert'
import { objCopy } from '@/services/helper'
import { profileViewTemplate } from '@/config/account'
import { gameWarsChangeStatusButtonTemplates } from '@/config/game'

export default {
  name: 'AccountMypage',
  components: {
    CommonWithRightColumnTransportTemplate,
    AccountRightMenu,
    TextMark,
    Status,
    Button,
    Img,
    Loading,
    Alert,
  },
  data() {
    return {
      profileView: profileViewTemplate,
      gameWarsChangeStatusButtons: gameWarsChangeStatusButtonTemplates,
      isGameStatusUpdateButtonDisabled: false,
      myGameRecordLoading: false,
      myGameRecords: [],
      alert: null,
      emailNotRegisteredAlert: null,
    }
  },
  mounted() {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
    })
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))

    this.fetchMyGameList()

    this.check()
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  methods: {
    ...mapActions('accountStore', ['myGameList', 'myGameStatusUpdate']),
    check() {
      this.emailNotRegisteredAlert = {
        show: true,
        type: 'error',
        message: 'メールアドレスが設定されていません。',
      }
    },
    fetchMyGameList() {
      this.myGameRecordLoading = true;
      new Promise((resolve) => {
        resolve(this.myGameList())
      })
      .then( (res) => {
        this.$set(this, 'myGameRecords', res);
        this.myGameRecordLoading = false;
      })
      .catch( (err) => {
        this.alert = {
          show: true,
          type: 'error',
          message: err,
        }
      })
    },
    updateGameRecord(label, gameRecordId, status, winningTeam) {
      if(!confirm(`${label}で記録を付けます。よろしいでしょうか？`)) {
        return;
      }

      this.isGameStatusUpdateButtonDisabled = true;

      new Promise((resolve) => {
        resolve(this.myGameStatusUpdate({
          gameRecordId: gameRecordId,
          status: status,
          winningTeam: winningTeam
        }))
      })
      .then( (res) => {
        this.alert = {
          show: true,
          type: 'info',
          message: res,
        }

        this.fetchMyGameList();
      })
      .catch( (err) => {
        this.alert = {
          show: true,
          type: 'error',
          message: err,
        }
      })
      .finally( () => {
        this.isGameStatusUpdateButtonDisabled = false;
      })
    },
  },
}
</script>
