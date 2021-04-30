<template>
  <input
    type="file"
    :accept="accept"
    @change="fileUpload"
    :disabled="disabled"
  />
</template>

<script>
export default {
  name: 'FileUpload',
  props: {
    accept: {type: String, default: ''},
    disabled: {type: Boolean, default: false},
  },
  methods: {
    fileUpload() {}
  }
}
</script>