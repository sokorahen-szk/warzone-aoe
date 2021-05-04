<template>
  <div>
    <TextInput
      :value="search"
      @update="search = $event"
      placeholder="プレイヤー名を検索する"
      outlined
      required
    />
    <PlayerList
      :players="setPlayers"
      @click="update"
    />
  </div>
</template>

<script>
import TextInput from '@/components/atoms/TextInput'
import PlayerList from '@/components/molecules/PlayerList'

export default {
  name: 'PlayerSearchBox',
  components: {
    TextInput,
    PlayerList
  },
  props: {
    players: {type: Array, default: []}
  },
  data() {
    return {
      search: '',
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
        return player.name.indexOf(this.search) != -1
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