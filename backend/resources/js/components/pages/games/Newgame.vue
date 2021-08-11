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

  </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import PlayerSearchBox from '@organisms/PlayerSearchBox'
import Select from '@atoms/Select'
import Button from '@atoms/Button'
import { playerListTemplate } from '@/config/player'
import { mapGetters, mapActions } from 'vuex'
import { selectParser, addStyleParser } from '@/services/helper'
export default {
  name: 'Newgame',
  components: {
    CommonOneColumnTemplate,
    PlayerSearchBox,
    Select,
    Button
  },
  mounted() {
    this.playerList();

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'playerStore/setPlayers') {
        this.$set(this, 'players', this.getPlayers)
      } else if (mutation.type === 'gameStore/setPackageList') {
        this.$set(this, 'gamePackages', selectParser(this.getPackageList, {label: 'name', value: 'id'}))
      } else if (mutation.type === 'gameStore/setMapList') {
        this.$set(this, 'gameMaps', selectParser(this.getMapList, {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
      }
    })

  },
  computed: {
    ...mapGetters('playerStore', ['getPlayers']),
    ...mapGetters('gameStore', ['getPackageList', 'getMapList']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
    getGameMap() {
      if (!this.selectedGamePackageId) return this.gameMaps
      return this.gameMaps.map( item => item.gamePackageId === this.selectedGamePackageId)
    },
    addStyle() {
      if (this.getDeviceType !== 'sp') {
        return addStyleParser({
          'border-right': '1px #ddd solid',
        })
      }
    }
  },
  methods: {
    ...mapActions('playerStore', ['playerList']),
    updatePlayer(e) {
      if (!e) return;
      if (this.selectedPlayers.find( player => player.id == e.id )) return;
      if (this.selectedPlayers.length >= 8) return;
      this.selectedPlayers.push(e);
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
    },
  },
  watch: {
    selectedGamePackageId(val) {
      if (val) {
        const maps = this.getMapList.find( map => map.id == val)
        if (maps) {
          this.$set(this, 'gameMaps', selectParser(maps, {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
        } else {
          this.$set(this, 'gameMaps', selectParser([], {label: 'name', value: 'id', gamePackageId: 'gamePackageId'}))
        }
      }
    }
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

      // TODO: ルールのAPIがまだのため、ダミーデータを渡しておく
      gameRules: [
        {id: 1, value: 1, label: "サンプル"}
      ]
    }
  }
}
</script>