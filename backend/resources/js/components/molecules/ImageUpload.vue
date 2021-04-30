<template>
  <div>
    <FileUpload :accept="setAccept" />
  </div>
</template>

<script>
import FileUpload from '@/components/atoms/FileUpload'
export default {
  name: 'ImageUpload',
  components: {
    FileUpload
  },
  data() {
    return {
      //
    }
  },
  setAccept() {
    return "image/jpeg, image/png"
  }
}
</script>