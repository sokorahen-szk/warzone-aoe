<template>
  <div>
    <TextInput
      :value="search"
      @update="search = $event"
      placeholder="プレイヤー名を検索する"
      outlined
      required
    />
    <div class="suggestion">
      <PlayerList
        v-show="setPlayers.length > 0"
        :players="setPlayers"
        @click="update"
      />
    </div>
  </div>
</template>

<style scoped>
.suggestion {
  position: relative;
  top: -30px;
}
</style>

<script>
import TextInput from '@/components/atoms/TextInput'
import PlayerList from '@/components/molecules/PlayerList'

export default {
  name: 'PlayerSearchBox',
  components: {
    TextInput,
    PlayerList,
  },
  props: {
    keyword: {type: String, default: null},
    players: {type: Array, default: []},
  },
  data() {
    return {
      search: this.keyword,
    }
  },
  watch: {
  },
  computed: {
    setPlayers() {
      if (!this.search) {
        return []
      }

      return this.players.filter( player => {
        if (player.name === null) {
          return false;
        }
        return player.name.toUpperCase().indexOf(this.search.toUpperCase()) != -1
      })
    }
  },
  methods: {
    update(e) {
      return this.$emit('update', e)
    }
  }
}
</script>