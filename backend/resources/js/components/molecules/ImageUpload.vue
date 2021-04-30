<template>
  <div>
    <FileUpload :accept="setAccept" @update="upload">
      <v-card outlined tile>
        <v-row justify="center" align-content="center" style="height: 200px;">
          <v-icon size="32">mdi-camera-plus-outline</v-icon>
        </v-row>
      </v-card>
    </FileUpload>
  </div>
</template>

<style scoped>
.image-upload {
  cursor: pointer !important;
}
</style>

<script>
import FileUpload from '@/components/atoms/FileUpload'
export default {
  name: 'ImageUpload',
  components: {
    FileUpload
  },
  data() {
    return {
    }
  },
  computed: {
    setAccept() {
      return "image/jpeg, image/png"
    }
  },
  methods: {
    click(){},
    upload(e) {
      console.log(e)
    }
  }
}
</script>