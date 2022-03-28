<template>
  <v-card flat>
    <v-card-title>
      レーティング
      <v-spacer></v-spacer>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="players"
      :items-per-page="perPage"
      class="player-table"
      @click:row="onClickEvent"
    >
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  name: 'PlayerTable',
  props: {
    perPage: {type: Number, default: 10},
    players: {type: Array, default: []},
  },
  data() {
    return {
      search: '',
      headers: [
        {
          text: 'プレイヤー名',
          align: 'start',
          value: 'name',
        },
        { text: 'レート', value: 'rate' },
        { text: 'ランク', value: 'rank' },
        { text: '試合数', value: 'games' },
        { text: '勝利', value: 'win' },
        { text: '敗北', value: 'defeat' },
        { text: '引分', value: 'draw' },
        { text: '勝率', value: 'wp' },
      ],
    }
  },
  methods: {
    onClickEvent(data) {
      this.$router.push(`/player/${data.id}`)
    }
  }
}
</script>
