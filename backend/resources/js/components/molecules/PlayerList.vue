<template>
  <v-list flat>
    <v-list-item v-for="(player, index) in players" :key="index" :to="`player/${player.id}`">
      <v-list-item-avatar>
        <v-img
          :src="player.image"
        ></v-img>
      </v-list-item-avatar>
      <v-list-item-content>
        {{player.name}}
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  name: 'PlayerList',
  props: {
    players: {type: Array, default: []}
  },
  data() {
    return {
      //
    }
  }
}
</script>
