<template>
  <div>
    <slot name="header"></slot>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              ID
            </th>
            <th class="text-left">
              プレイヤー名
            </th>
            <th class="text-left">
              ランク
            </th>
            <th class="text-left">
              mu
            </th>
            <th class="text-left">
              sigma
            </th>
            <th class="text-left">
              レート
            </th>
            <th class="text-left">
              ステータス
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="player in players"
            :key="player.id"
          >
            <td>{{ player.id }}</td>
            <td>
              <v-avatar
                color="grey lighten-2"
                size="40"
              >
                <img :src="player.avatorImage" />
              </v-avatar>
              {{ player.name }}
            </td>
            <td>{{ player.rank }}</td>
            <td>0</td>
            <td>{{ player.sigma }}</td>
            <td>{{ player.rate }}</td>
            <td>{{ player.enabled }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
export default {
    name:'AdminPlayerTable',
    props: {
      players: {type: Array},
    }
}
</script>
