<template>
  <label for="filename">
    <slot></slot>
    <input
      type="file"
      id="filename"
      :accept="accept"
      @change="fileUpload"
      :disabled="disabled"
    />
  </label>
</template>

<style scoped>
  @media screen {
      #filename {
        display: none;
      }
  }
  .browse {
    width: 100%;
    max-width: 250px;
    text-align: center;
    padding: 7px 7px;
    border: 1px #ccc solid;
    margin: 0 auto;
  }
  .browse:hover {
    background-color: #eee;
    font-weight: bold;
    cursor: pointer;
  }
</style>

<script>
export default {
  name: 'FileUpload',
  props: {
    accept: {type: String, default: ''},
    disabled: {type: Boolean, default: false},
  },
  methods: {
    fileUpload(e) {
      const files = e.target.files || e.dataTransfer.files;
      return this.$emit('update', files)
    }
  }
}
</script>