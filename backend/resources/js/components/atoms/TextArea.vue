<template>
  <v-textarea
    v-model="t"
    :solo="solo"
    :outlined="outlined"
    :name="name"
    :label="label"
    :placeholder="placeholder"
  ></v-textarea>
</template>

<script>
export default {
  name: 'TextArea',
  props: {
    label: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    value: { type: String, default: '' },
    name: { type: String, default: 'name' },
    solo: { type: Boolean, default: false },
    outlined: { type: Boolean, default: false },
  },
  mounted() {
    this.t = this.value
  },
  watch: {
    t: function(value) {
      return this.$emit('update', value)
    },
    value: function (newValue) {
      this.t = newValue
    }
  },
  data() {
    return {
      t: null,
    }
  }
}
</script>