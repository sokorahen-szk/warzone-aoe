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
        <v-list class="pa-0 ma-0">
            <v-row no-gutters class="pa-3">
              <v-col cols="2">ID</v-col>
              <v-col cols="3">マップ</v-col>
              <v-col cols="3">ゲーム</v-col>
              <v-col cols="2">ステータス</v-col>
              <v-col cols="2" class="text-right">人数</v-col>
            </v-row>
            <v-divider />
          <Loading v-if="isLoading" size="48" class="pt-4" />
          <v-list-item
            class="pa-0 ma-0"
            @click="show(gameRecord)"
            v-for="gameRecord in gameRecordList"
            :key="`game-record-list-${gameRecord.gameRecordId}`"
            v-else
          >
            <v-row no-gutters class="pa-2">
              <v-col cols="2">{{gameRecord.gameRecordId}}</v-col>
              <v-col cols="3">{{gameRecord.gameMap.name}}</v-col>
              <v-col cols="3">{{gameRecord.gamePackage.name}}</v-col>
              <v-col cols="2">{{gameStatus(gameRecord.status)}}</v-col>
              <v-col cols="2" class="text-right">{{gameRecord.playerCount}} / 8</v-col>
            </v-row>
          </v-list-item>
        </v-list>
        <Pagination
          :current="currentPage"
          :length="getAllTotalPage"
          @change="changePage"
          v-if="!isLoading"
        />
<Modal
  title="ゲーム詳細"
  :show="isShow"
  @update="isShow = $event"
>
  <v-row v-if="gameRecordDetail">
    <v-col cols="6">
      <div class="py-2 text-center light-blue lighten-4">チーム1</div>
      <v-list flat>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">プレイヤー名</v-col>
              <v-col cols="4" class="text-center">ランク</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
       <v-divider />
        <v-list-item v-for="data in gameRecordDetail.playerMemories[1]" :key="`player-id-${data.playerId}`">
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">{{data.playerName}}</v-col>
              <v-col cols="4" class="text-center">{{data.rank}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">合計ランク</v-col>
              <v-col cols="4" class="text-center">{{sumPlayerRank(gameRecordDetail.playerMemories[1])}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-col>
    <v-col cols="6">
      <div class="py-2 text-center light-blue lighten-4">チーム2</div>
      <v-list flat>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">プレイヤー名</v-col>
              <v-col cols="4" class="text-center">ランク</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
       <v-divider />
        <v-list-item v-for="data in gameRecordDetail.playerMemories[2]" :key="`player-id-${data.playerId}`">
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">{{data.playerName}}</v-col>
              <v-col cols="4" class="text-center">{{data.rank}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">合計ランク</v-col>
              <v-col cols="4" class="text-center">{{sumPlayerRank(gameRecordDetail.playerMemories[2])}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-col>
    <v-col cols="6" class="text-center">ゲーム</v-col>
    <v-col cols="6">{{gameRecordDetail.gamePackage.name}}</v-col>
    <v-col cols="6" class="text-center">マップ</v-col>
    <v-col cols="6">{{gameRecordDetail.gameMap.name}}</v-col>
    <v-col cols="6" class="text-center">ルール</v-col>
    <v-col cols="6">{{gameRecordDetail.gameRule.name}}</v-col>
    <v-col cols="12" class="text-center mb-3">
      <Button
        v-for="t in gameWarsChangeStatusButtons"
        class="ml-2"
        :disabled="isGameStatusUpdateButtonDisabled"
        :color="t.color"
        :label="t.label"
        :key="t.label"
        @click="updateGameRecord(t.label, gameRecordDetail.gameRecordId, t.game_status, t.winningTeam)"
        depressed
      />
    </v-col>
  </v-row>
</Modal>

      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import { gameWarsChangeStatusButtonTemplates } from '@/config/game'
import Modal from '@atoms/Modal'
import { mapActions, mapGetters } from 'vuex'
import { profileViewTemplate } from '@/config/account'
import { gameStatusLabels } from '@/config/game'
import { alertTemplate } from '@/config/global'
import { objCopy } from '@/services/helper'
import Loading from '@atoms/Loading'
import Pagination from '@atoms/Pagination'
import Button from '@atoms/Button'
import Alert from '@atoms/Alert'

export default {
  name: 'Game',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    Modal,
    Loading,
    Pagination,
    Button,
    Alert,
  },
  data() {
      return {
        profileView: profileViewTemplate,
        isLoading: false,
        isShow: false,
        isGameStatusUpdateButtonDisabled: false,
        gameRecordList: [],
        gameRecordDetail: null,
        currentPage: 1,
        gameWarsChangeStatusButtons: gameWarsChangeStatusButtonTemplates,
        alert: alertTemplate,
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
    ...mapGetters('warStore', ['getAllTotalPage']),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchAllWarHistoryList',
    }),
    ...mapActions('gameStore', ['adminGameFinished']),
    fetchWarHistoryList(page) {
      this.isLoading = true
      new Promise((resolve) => {
        resolve(this.fetchWarHistoryListToStore({page: page}))
      })
      .then(res => {
        this.setGameRecordList(page)
        this.isLoading = false
      })
    },
    setGameRecordList(page) {
      if(!page){
        return
      }
      this.gameRecordList = this.$store.getters['warStore/getAllWarHistoryList'](page)
    },
    gameStatus(status) {
      const gameStatusLabel = gameStatusLabels.find( (gameStatusLabel) => {
        return gameStatusLabel.id === status
      })

      return gameStatusLabel && gameStatusLabel.label
    },
    sumPlayerRank(playerMemories) {
      let ranks = []
      playerMemories.forEach( (playerMemory) => {
        ranks.push(playerMemory.rank)
      })
      return ranks.reduce( (acc, cur) => {
        return acc + cur
      })
    },
    show(gameRecord) {
      this.$set(this, 'gameRecordDetail', gameRecord)
      this.isShow = true
    },
    changePage(page) {
      this.currentPage = page
      this.fetchWarHistoryList(page)
    },
    updateGameRecord(label, gameRecordId, status, winningTeam) {
      if(!confirm(`${label}で記録を付けます。よろしいでしょうか？`)) {
        return
      }

      this.isGameStatusUpdateButtonDisabled = true

      new Promise((resolve) => {
        resolve(this.adminGameFinished({
          gameRecordId: gameRecordId,
          status: status,
          winningTeam: winningTeam
        }))
      })
      .then( () => {
        this.isShow = false
        this.fetchWarHistoryList(this.currentPage)
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
      .finally( () => {
        this.isGameStatusUpdateButtonDisabled = false
      })
    },
  },
  created() {
    this.fetchWarHistoryList(this.currentPage)
  },
}
</script>
