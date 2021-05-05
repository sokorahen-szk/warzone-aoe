<template>
  <CommonOneColumnTemplate back-ground='#eee'>
  <template slot="container">

    <v-row no-gutters>
      <v-col cols="12" sm="12" md="5" lg="4" class="px-2" style="border-right: 1px #ddd solid;">
        <div class="py-2">プレイヤー選択</div>
        <PlayerSearchBox
          :players="players"
          @update="updatePlayer"
        />

        <div class="py-2">ゲーム設定</div>
        <v-row no-gutters>
          <v-col cols="12" class="mb-2">
            <Select
              label="ゲームパッケージを選択する"
              :items="items"
            />
          </v-col>
          <v-col cols="12" class="mb-2">
            <Select
              label="ルールを選択する"
              :items="items"
            />
          </v-col>
          <v-col cols="12">
            <Select
              label="マップを選択する"
              :items="items"
            />
          </v-col>
        </v-row>

      </v-col>
      <v-col cols="12" sm="12" md="7" lg="8">

        <v-row no-gutters>
          <v-col cols="12" style="min-height: 450px;" class="pa-2">
            <div class="text-center mb-2">
              選択プレイヤー ({{selectedPlayers.length}}/8) 人
            </div>
            <v-card v-for="player in selectedPlayers" :key="player.id" class="headline py-4 mb-2">
              <v-row no-gutters>
                <v-col class="pl-2">{{player.name}}</v-col>
                <v-col>rank:{{player.rank}}</v-col>
                <v-spacer />
                <v-col cols="1" class="text-center">
                  <v-icon color="red" @click="deletePlayer(player.id)">mdi-delete</v-icon>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
          <v-col cols="12">
            <v-row no-gutters justify="center" align-content="center">
              <Button
                class="mr-2"
                color="info"
                label="チーム分け"
                height="55"
                width="150"
              />
              <Button
                class="ml-2"
                color="warning"
                label="キャンセル"
                width="150"
                height="55"
              />
            </v-row>
          </v-col>
        </v-row>

      </v-col>
    </v-row>

  </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import PlayerSearchBox from '@/components/organisms/PlayerSearchBox'
import Select from '@/components/atoms/Select'
import Button from '@/components/atoms/Button'
import { playerListTemplate } from '@/config/player'
import { mapGetters, mapActions } from 'vuex'

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
      }
    })
  },
  computed: {
    ...mapGetters('playerStore', ['getPlayers']),
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
    }
  },
  data() {
    return {
      search: null,
      players: [playerListTemplate],
      selectedPlayers: [],
      items: [
        {id: 1, value: "A", label: "AAA"}
      ]
    }
  }
}
</script>