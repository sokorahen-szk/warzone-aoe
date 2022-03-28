<template>
  <v-checkbox
    class="ma-0 pa-0"
    v-model="select"
    :label="label"
    :value="value"
    @change="changeEvent"
  ></v-checkbox>
</template>

<script>
export default {
  name: 'CheckBox',
  props: {
    selected: {type: Boolean, default: false},
    label: {type: String, default: ''},
    value: {type: [String, Number, Boolean], default: ''},
  },
  data() {
    return {
      select: this.selected,
    }
  },
  methods: {
    changeEvent() {
      return this.$emit('update', this.select)
    }
  }
}
</script>