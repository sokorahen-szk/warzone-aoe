<template>
  <v-text-field
    v-model="t"
    :required="required"
    :rounded="rounded"
    :filled="filled"
    :outlined="outlined"
    dense
    class="pa-0 ma-0"
    :placeholder="placeholder"
    flat
  ></v-text-field>
</template>

<script>
export default {
  name: 'TextInput',
  props: {
    value: {type: String},
    required: {type: Boolean, default: false},
    placeholder: {type: String, default: null},
    rounded: {type: Boolean, default: false},
    filled: {type: Boolean, default: false},
    outlined: {type: Boolean, default: false},
  },
  data() {
    return {
      t: null
    }
  },
  mounted() {
    this.t = this.value
  },
  watch: {
    t: function(value) {
      return this.$emit('update', value)
    }
  }
}
</script>