<template>
  <div>
  <v-simple-table dense>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            ゲーム
          </th>
          <th class="text-center">
            勝利
          </th>
          <th class="text-center">
            ステータス
          </th>
          <th class="text-center">
            開始時間
          </th>
          <th class="text-center">
            終了時間
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(record, i) in records">
        <tr :key="`game-record-top-${record.id}`" @click="detail(record.id)">
          <td>{{record.game_package_id}}</td>
          <td>{{record.winning_team}}</td>
          <td>{{record.status}}</td>
          <td>{{record.started_at}}</td>
          <td>{{record.finished_at}}</td>
        </tr>
        <tr v-show="(recordDetail.length !== 0 && recordDetail[i].id === record.id) && recordDetail[i].show" :key="`game-record-bottom-${record.id}`" class="tr">
          <td colspan="5">
            <v-row no-gutters>
              <v-col cols="6" class="text-center">
                <div>チーム1</div>
                <v-list dense class="pa-0 ma-0">
                  <v-list-item v-for="(team, index) in record.teams.team1" :key="`game-record-bottom-team-1-${index}`">
                    <v-list-item-avatar>
                      <Avator size="32" :src="team.avator" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-row no-gutters>
                        <v-col class="text-center">{{team.name}}</v-col>
                        <v-col class="text-right">{{team.rate}}</v-col>
                      </v-row>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-col>
              <v-col cols="6" class="text-center">
                <div>チーム2</div>
                <v-list dense class="pa-0 ma-0">
                  <v-list-item v-for="(team, index) in record.teams.team2" :key="`game-record-bottom-team-2-${index}`">
                    <v-list-item-avatar>
                      <Avator size="32" :src="team.avator" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-row no-gutters>
                        <v-col class="text-center">{{team.name}}</v-col>
                        <v-col class="text-right">{{team.rate}}</v-col>
                      </v-row>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
          </td>
        </tr>
        </template>
      </tbody>
    </template>
  </v-simple-table>
  </div>
</template>

<style scoped>
thead > tr {
  background: #eee;
}

tbody > tr {
  cursor: pointer !important;
}

tbody > tr > td {
  height: 50px !important;
}
.tr:hover {
  background: transparent !important;
}
</style>

<script>
import Avator from '@/components/atoms/Avator'

export default {
  name: 'GameRecordTable',
  components: {
    Avator,
  },
  data() {
    return {
      records: [
        {id: 1, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 2, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 3, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 5, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 6, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 7, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 8, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 9, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
        {id: 10, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22", teams: {team1: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}], team2: [{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"},{rate: 2000, name:"titan", avator:"https://placehold.jp/150x150.png"}]}},
      ],
      recordDetail: [],
    }
  },
  mounted() {
    this.recordDetail = Object.assign([], this.records.map( (record) => {
      return {id: record.id, view: false}
    }))
  },
  methods: {
    detail(id) {
      find = this.recordDetail.find( record => record.id === id)
      if(find) {
        find.show = !find.show
      }

      this.recordDetail.splice()
    }
  }
}
</script>
