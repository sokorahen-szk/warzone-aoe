<template>
  <v-radio-group v-model="selectedRadio" class="ma-0 pa-0" @change="changeEvent">
    <v-radio
      v-for="item in items"
      :key="item.label"
      :label="item.label"
      :value="item.value"
    ></v-radio>
  </v-radio-group>
</template>

<script>
export default {
  name: 'RadioBox',
  props: {
    selected: {type: Number, default: 0},
    items: {type: Array, default: []},
  },
  data() {
    return {
      selectedRadio: this.selected,
    }
  },
  methods: {
    changeEvent() {
      return this.$emit('update', this.selectedRadio)
    }
  }
}
</script>