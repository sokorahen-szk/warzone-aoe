<template>
  <div>
  <v-simple-table dense>
    <template v-slot:default>
      <thead>
        <tr @click="detail">
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
        <tr v-for="record in records" :key="record.id">
          <td>{{record.game_package_id}}</td>
          <td>{{record.winning_team}}</td>
          <td>{{record.status}}</td>
          <td>{{record.started_at}}</td>
          <td>{{record.finished_at}}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
  </div>
</template>

<style scoped>
tbody > tr {
  cursor: pointer !important;
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
        {id: 1, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22"},
        {id: 2, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22"},
        {id: 3, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22"},
        {id: 4, game_package_id: "AoE2DE", winning_team: "チーム1", status: "ゲーム終了", started_at: "2020-01-01 00:00:00", finished_at: "2021-01-01 22:22:22"},
      ]
    }
  },
  methods: {
    detail(id) {

    }
  }
}
</script>
