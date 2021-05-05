<template>
  <v-sheet
    class="overflow-y-auto"
    max-height="200"
    outlined
  >
  <v-list flat class="pa-0 ma-0" dense>
    <template v-for="(player, index) in players">
      <v-list-item :key="index" @click="link(player)">
        <v-list-item-avatar v-show="player.image">
          <v-img
            :src="player.image"
          ></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-row no-gutters class="ma-0 pa-0">
            <v-col cols="6">{{player.name}}</v-col>
            <v-col cols="6" class="text-right" v-show="player.rank != null">rank:{{player.rank}}</v-col>
          </v-row>
        </v-list-item-content>
      </v-list-item>
      <v-divider :key="`divider-${index}`" />
    </template>
    </v-list>
  </v-sheet>
</template>

<script>
import router from '@/router/index'
export default {
  name: 'PlayerList',
  props: {
    players: {type: Array, default: []}
  },
  methods: {
    link(player) {
      if (player['link']) {
        router.push({path: `player/${player.id}`})
      }
      return this.$emit('click', player)
    }
  },
  data() {
    return {
    }
  }
}
</script>
