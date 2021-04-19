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
  ></v-text-field>
</template>

<script>
export default {
  name: 'PasswordTextInput',
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
  }
}
</script>