<template>
  <v-radio-group v-model="selectedRadio" @change="changeEvent">
    <v-radio
      v-for="item in items"
      :key="item.label"
      :label="item.label"
      :value="item.value"
    ></v-radio>
  </v-radio-group>
</template>

<style scoped>
* >>> .v-messages {
  min-height: 0px !important;
}
</style>

<script>
export default {
  name: 'RadioBoxList',
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