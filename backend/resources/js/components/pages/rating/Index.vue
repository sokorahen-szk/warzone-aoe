<template>
  <v-container>
    <CommonOneColumnTemplate>
    <template slot="container">
      <PlayerTable :players="players" />
    </template>
    </CommonOneColumnTemplate>
  </v-container>
</template>

<script>
import { playerListTemplate } from '@/config/player'
import PlayerTable from '@/components/organisms/PlayerTable'
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Index',
  components: {
    CommonOneColumnTemplate,
    PlayerTable
  },
  data() {
    return {
      players: [playerListTemplate],
    }
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
  }
}
</script>
