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
    :rules="setRule"
    :background-color="color"
  ></v-text-field>
</template>

<script>
import { validator } from '@/services/validator'
export default {
  name: 'TextInput',
  props: {
    value: {type: String},
    required: {type: Boolean, default: false},
    placeholder: {type: String, default: null},
    rounded: {type: Boolean, default: false},
    filled: {type: Boolean, default: false},
    outlined: {type: Boolean, default: false},
    rules: {type: Object, default: null},
    color: {type: String, default: null},
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
  },
  computed: {
    setRule() {
      return validator(this.rules);
    }
  }
}
</script>