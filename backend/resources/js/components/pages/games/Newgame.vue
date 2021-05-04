<template>
  <CommonOneColumnTemplate back-ground='#eee'>
  <template slot="container">

    <v-row no-gutters>
      <v-col cols="4">
        <PlayerSearchBox
          :players="players"
          @update="updatePlayer"
        />
      </v-col>
      <v-col cols="8" class="px-2">
        <div class="text-center">
          選択プレイヤー ({{selectedPlayers.length}}/8) 人
        </div>
        <v-card v-for="player in selectedPlayers" :key="player.id" class="py-4 mb-2 headline">
          <v-row no-gutters>
            <v-col class="pl-2">{{player.name}}</v-col>
            <v-col>rank:{{player.rank}}</v-col>
            <v-spacer />
            <v-col cols="1" class="text-center">
              <v-icon color="red" @click="deletePlayer(player.id)">mdi-delete</v-icon>
            </v-col>
          </v-row>
        </v-card>
        <v-row no-gutters class="mt-4">
          <v-col cols="12">
            <Select
              :items="items"
            />
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
import { playerListTemplate } from '@/config/player'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Newgame',
  components: {
    CommonOneColumnTemplate,
    PlayerSearchBox,
    Select,
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