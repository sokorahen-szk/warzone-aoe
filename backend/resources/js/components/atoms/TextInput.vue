<template>
  <v-text-field
    v-model="t"
    :required="required"
    :rounded="rounded"
    :filled="filled"
    :outlined="outlined"
    dense
    class="pa-0 ma-0 text"
    :placeholder="placeholder"
    flat
    :rules="setRule"
    :background-color="setColor"
    :disabled="disabled"
    :autocomplete="autocomplete"
  ></v-text-field>
</template>

<script>
import { validator } from '@/services/validator'
export default {
  name: 'TextInput',
  props: {
    value: {type: [String, Number]},
    required: {type: Boolean, default: false},
    placeholder: {type: String, default: null},
    rounded: {type: Boolean, default: false},
    filled: {type: Boolean, default: false},
    outlined: {type: Boolean, default: false},
    rules: {type: Object, default: null},
    color: {type: String, default: '#fffffe'},
    disabled: {type: Boolean, default: false},
    autocomplete: {type: String, default: 'off'},
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
    },
    value: function (newValue) {
      this.t = newValue
    }
  },
  computed: {
    setRule() {
      return validator(this.rules);
    },
    setColor() {
      return this.disabled ? '#eee' : '#fffffe'
    }
  }
}
</script>