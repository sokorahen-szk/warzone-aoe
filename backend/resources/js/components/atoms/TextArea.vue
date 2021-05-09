<template>
  <v-textarea
    :solo="solo"
    :outlined="outlined"
    :name="name"
    :value="value"
    :label="label"
    :placeholder="placeholder"
  ></v-textarea>
</template>

<style scoped>
* >>> .v-messages {
  min-height: 0px !important;
}
</style>

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
  data() {
    return {

    }
  }
}
</script>