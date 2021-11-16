<template>
  <CommonOneColumnTemplate
    back-ground='#eee'
    :device="getDeviceType"
    :sheetPaClass="'pa-3'"
  >
  <template slot="container">
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="5" lg="4" class="px-2" :style="addStyle">
        <div class="py-2 text-h6">プレイヤー選択</div>
        <PlayerSearchBox
          :keyword="search"
          :players="players"
          :selected-players="selectedPlayers"
          @update="updatePlayer"
          @input="search = $event"
        />

        <div class="py-2 text-h6">ゲーム設定</div>
        <v-row no-gutters>
          <v-col cols="12" class="mb-2">
            <Select
              label="ゲームパッケージを選択する"
              :items="gamePackages"
              :selectedIndex="selectedGamePackageId"
              @input="selectedGamePackageId = $event"
              :disabled="gamePackages.length < 1"
            />
          </v-col>
          <v-col cols="12" class="mb-2">
            <Select
              label="ルールを選択する"
              :items="gameRules"
              :selectedIndex="selectedRuleId"
              @input="selectedRuleId = $event"
              :disabled="gameRules.length < 1"
            />
          </v-col>
          <v-col cols="12">
            <Select
              label="マップを選択する"
              :items="gameMaps"
              :selectedIndex="selectedMapId"
              @input="selectedMapId = $event"
              :disabled="gameMaps.length < 1"
            />
          </v-col>
        </v-row>

      </v-col>
      <v-col cols="12" sm="12" md="7" lg="8">

        <v-row no-gutters>
          <v-col cols="12" style="min-height: 500px;" class="pa-2">
            <v-card class="pa-2">
              <div class="text-center mb-2 text-h6">
                選択プレイヤー ({{selectedPlayers.length}}/8) 人
              </div>
              <v-card
                v-for="player in selectedPlayers"
                :key="player.id"
                class="caption py-2 mb-2"
                outlined
              >
                <v-row no-gutters>
                  <v-col class="pl-2">{{player.name}}</v-col>
                  <v-col>rank:{{player.rank}}</v-col>
                  <v-spacer />
                  <v-col cols="1" class="text-center">
                    <v-icon
                      left
                      size="18"
                      color="red"
                      @click="deletePlayer(player.id)"
                    >
                      mdi-delete
                    </v-icon>
                  </v-col>
                </v-row>
              </v-card>
              <v-card
                v-for="n of (8 - selectedPlayers.length)"
                :key="`player-${ selectedPlayers.length + n}`"
                class="caption pa-2 mb-2"
                color="#FAFAFA"
                :elevation="0"
              >
                プレイヤーを選択
              </v-card>
              <v-row no-gutters justify="center" align-content="center" style="height:100px;">
                <Button
                  class="mr-2"
                  color="info"
                  label="チーム分け"
                  width="200"
                  height="55"
                  :disabled="selectedPlayers.length < 2"
                  @click="division"
                />
                <Button
                  class="ml-2"
                  color="warning"
                  label="クリア"
                  width="200"
                  height="55"
                  @click="clearEvent"
                />
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

<Modal
  title="チーム分け"
  :show="isTeamDivision"
  @update="isTeamDivision = $event"
>
  <v-row v-if="teamDivisionResponse">
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
        <v-list-item v-for="data in teamDivisionResponse.team1" :key="`player-id-${data.id}`">
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">{{data.name}}</v-col>
              <v-col cols="4" class="text-center">{{data.rank}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">合計ランク</v-col>
              <v-col cols="4" class="text-center">{{teamDivisionResponse.team1RankSum}}</v-col>
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
        <v-list-item v-for="data in teamDivisionResponse.team2" :key="`player-id-${data.id}`">
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">{{data.name}}</v-col>
              <v-col cols="4" class="text-center">{{data.rank}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-row no-gutters>
              <v-col cols="8">合計ランク</v-col>
              <v-col cols="4" class="text-center">{{teamDivisionResponse.team2RankSum}}</v-col>
            </v-row>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-col>
    <v-col cols="12">
      <div class="text-center">quality：{{teamDivisionResponse.quality}}%</div>
      <v-row no-gutters>
        <v-col class="px-2 text-h4" cols="auto">良</v-col>
        <v-col>
          <QualityBar :quality="teamDivisionResponse.quality" height="35" />
        </v-col>
        <v-col class="px-2 text-h4" cols="auto">悪</v-col>
      </v-row>
      <v-row no-gutters>
        <v-col cols="12" sm="12" md="6" lg="6" xl="6" :class="getDeviceType === 'pc' ? 'text-right': 'text-center'" class="mt-2">
          <Button
            color="success"
            label="ゲーム開始"
            width="200"
            height="55"
            @click="matching"
          />
        </v-col>
        <v-col cols="12" sm="12" md="6" lg="6" xl="6" :class="{'text-center': getDeviceType === 'sp'}" class="mt-2">
          <Button
            color="normal"
            label="キャンセル"
            width="200"
            height="55"
            @click="isTeamDivision = false"
          />
        </v-col>
      </v-row>
    </v-col>
  </v-row>
  <Loading
    size="64"
    v-else
  />
</Modal>
<Modal
  title="マッチング"
  :show="isMatching"
  @update="isMatching = $event"
>
  <div v-if="isFinished">
    試合が終了しました。お疲れ様でした。
  </div>
  <div v-else>
    ゲームが開始されました。
    <v-row no-gutters>
      <v-col cols="12">
        <Button
          v-for="t in gameWarsChangeStatusButtons"
          class="ml-2"
          :disabled="isGameStatusUpdateButtonDisabled"
          :color="t.color"
          :label="t.label"
          :key="t.label"
          @click="updateGameRecord(t.label, matchingResponse.gameToken, t.game_status, t.winningTeam)"
          depressed
        />
      </v-col>
    </v-row>
  </div>
</Modal>

  </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import PlayerSearchBox from '@organisms/PlayerSearchBox'
import Select from '@atoms/Select'
import Button from '@atoms/Button'
import Modal from '@atoms/Modal'
import QualityBar from '@molecules/QualityBar'
import Loading from '@atoms/Loading'
import { playerListTemplate } from '@/config/player'
import { mapGetters, mapActions } from 'vuex'
import { selectParser, addStyleParser } from '@/services/helper'
import { gameWarsChangeStatusButtonTemplates } from '@/config/game'
export default {
  name: 'Newgame',
  components: {
    CommonOneColumnTemplate,
    PlayerSearchBox,
    Select,
    Button,
    Modal,
    QualityBar,
    Loading,
  },
  mounted() {
    this.$store.subscribe((mutation) => {
      switch (mutation.type) {
        case 'playerStore/setPlayers':
          this.$set(this, 'players', this.getPlayers)
          break
        case 'gameStore/setPackageList':
          this.$set(this, 'gamePackages', selectParser(this.getPackageList, {label: 'name', value: 'id'}))
          break
        case 'gameStore/setMapList':
           this.$set(this, 'gameMaps', selectParser(this.getMapList, {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
          break
        case 'gameStore/setRuleList':
           this.$set(this, 'gameRules', selectParser(this.getRuleList, {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
          break
      }
    })

    this.$set(this, 'players', this.getPlayers || [])
    this.$set(this, 'gamePackages', selectParser(this.getPackageList || [], {label: 'name', value: 'id'}))
    this.$set(this, 'gameMaps', selectParser(this.getMapList || [], {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
    this.$set(this, 'gameRules', selectParser(this.getRuleList || [], {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
  },
  computed: {
    ...mapGetters('playerStore', ['getPlayers']),
    ...mapGetters('gameStore', ['getPackageList', 'getMapList', 'getRuleList']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
    addStyle() {
      if (this.getDeviceType !== 'sp') {
        return addStyleParser({
          'border-right': '1px #ddd solid',
        })
      }
    }
  },
  methods: {
    ...mapActions('gameStore', ['teamDivision', 'gameMatching', 'gameFinished']),
    updatePlayer(e) {
      if (!e) return;
      if (this.selectedPlayers.length >= 8) return;

      if (e.isAdded) {
        this.selectedPlayers.push(e.player);
      } else {
        this.deletePlayer(e.player.id)
      }
    },
    deletePlayer(id) {
      const pos = this.selectedPlayers.find( player => player.id == id )
      if (pos !== -1) {
        this.selectedPlayers.forEach( (player, index) => {
          if (player.name === pos.name) {
             this.selectedPlayers.splice(index, 1)
          }
        })
      }
      this.selectedPlayers.splice() // リアクティブ反映
    },
    clearEvent() {
      this.search = null
      this.$set(this, 'selectedPlayers', [])

      this.selectedGamePackageId = 0
      this.selectedMapId = 0
      this.selectedRuleId = 0

      this.isGameStatusUpdateButtonDisabled = true
      this.teamDivisionResponse = null
      this.matchingResponse = null
    },
    division() {
      this.isTeamDivision = true

      new Promise ( reslve => {
        reslve(this.teamDivision({
          playerIds: this.selectedPlayers.map((item) => item.id),
          gamePackageId: Number(this.selectedGamePackageId),
          gameRuleId: Number(this.selectedRuleId),
          gameMapId: Number(this.selectedMapId),
        }))
      })
      .then( (res) => {
        this.teamDivisionResponse = res
      })
      .catch( (err) => {
        this.isTeamDivision = false

        alert(err)
      })
    },
    matching() {
      this.isTeamDivision = false
      this.isMatching = true

      new Promise ( reslve => {
        reslve(this.gameMatching({
          playerIds: this.selectedPlayers.map((item) => item.id),
          gamePackageId: Number(this.selectedGamePackageId),
          gameRuleId: Number(this.selectedRuleId),
          gameMapId: Number(this.selectedMapId),
        }))
      })
      .then( (res) => {
        this.matchingResponse = res
        this.isGameStatusUpdateButtonDisabled = false
      })
      .catch( (err) => {
        this.isMatching = false

        alert(err)
      })
    },
    updateGameRecord(label, token, status, winningTeam) {
      if(!confirm(`${label}で記録を付けます。よろしいでしょうか？`)) {
        return;
      }

      this.isGameStatusUpdateButtonDisabled = true;

      new Promise((resolve) => {
        resolve(this.gameFinished({
          token: token,
          status: status,
          winningTeam: winningTeam
        }))
      })
      .then( () => {
        this.isFinished = true
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
      .finally( () => {
        this.isGameStatusUpdateButtonDisabled = false;
      })
    },
  },
  watch: {
    selectedGamePackageId(val) {
      if (val) {
        const maps = this.getMapList.find( map => map.id == val)
        const rules = this.getRuleList.find( rule => rule.id == val)

        this.$set(this, 'gameMaps', selectParser(maps ? maps : [], {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
        this.$set(this, 'gameRules', selectParser(rules ? rules : [], {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
      }
    },
    isTeamDivision(val) {
      // dialogが閉じられた時
      if (!val) {
        this.$set(this, 'teamDivisionResponse', null)
      }
    },
  },
  data() {
    return {
      search: null,
      players: [playerListTemplate],
      selectedPlayers: [],
      selectedGamePackageId: 0,
      selectedMapId: 0,
      selectedRuleId: 0,
      gamePackages: [],
      gameMaps: [],
      gameRules: [],

      gameWarsChangeStatusButtons: gameWarsChangeStatusButtonTemplates,

      isTeamDivision: false,
      isMatching: false,
      isFinished: false,
      isGameStatusUpdateButtonDisabled: true,
      teamDivisionResponse: null,
      matchingResponse: null,
    }
  }
}
</script>