<template>
  <v-text-field
    v-model="t"
    :required="required"
    :rounded="rounded"
    :filled="filled"
    :outlined="outlined"
    :type="show ? 'text' : 'password'"
    :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
    dense
    class="pa-0 ma-0"
    :placeholder="placeholder"
    flat
    @click:append="show = !show"
    :rules="setRule"
    :background-color="color"
    :disabled="disabled"
    autocomplete="off"
  ></v-text-field>
</template>

<script>
import { validator } from '@/services/validator'
export default {
  name: 'PasswordTextInput',
  props: {
    value: {type: String},
    required: {type: Boolean, default: false},
    placeholder: {type: String, default: null},
    rounded: {type: Boolean, default: false},
    filled: {type: Boolean, default: false},
    outlined: {type: Boolean, default: false},
    rules: {type: Object, default: null},
    color: {type: String, default: '#fffffe'},
    disabled: {type: Boolean, default: false},
  },
  data() {
    return {
      t: null,
      show: false,
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
    },
    setColor() {
      return this.disabled ? '#eee' : '#fffffe'
    }
  }
}
</script>