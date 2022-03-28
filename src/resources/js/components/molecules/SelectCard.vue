<template>
  <v-card
    :max-width="maxWidth"
    :class="['select-card', {'cyan lighten-4': actived}]"
    @click="clickEvent"
  >
    <v-img
      :src="item.image"
      height="150"
    ></v-img>
    <v-card-title>
      {{item.title}}
    </v-card-title>
  </v-card>
</template>

<style scoped>
.select-card {
  cursor: pointer;
}
</style>

<script>
export default {
  name: 'SelectCard',
  props: {
    maxWidth: {type: [String, Number], default: 300},
    item: {type: Object, default: {}},
  },
  data() {
    return {
      actived: false,
    }
  },
  methods: {
    clickEvent() {
      this.actived = !this.actived
      return this.$emit('click', this.actived)
    }
  }
}
</script>