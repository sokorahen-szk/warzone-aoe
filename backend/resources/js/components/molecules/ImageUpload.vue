<template>
  <div>
    <FileUpload :accept="setAccept" @update="upload">
      <v-card outlined tile>
        <v-row justify="center" align-content="center" style="height: 200px;">
          <v-icon size="32" v-if="!image">mdi-camera-plus-outline</v-icon>
          <div class="pa-2">
            <Img
                v-if="image"
                :styles="{
                  'max-height': '200px',
                  'min-height': '200px',
                  'min-width': '60px'
                }"
                :src="image"
                thumbnail
            />
          </div>
        </v-row>
      </v-card>
    </FileUpload>
    <div class="py-2 text-center">
      <Button
        v-if="image"
        color="error"
        label="削除"
        @click="deleteImage"
      />
    </div>
  </div>
</template>

<script>
import FileUpload from '@/components/atoms/FileUpload'
import Button from '@/components/atoms/Button'
import Img from '@/components/atoms/Img'
export default {
  name: 'ImageUpload',
  props: {
    maxFileSize: {type: [String, Number], default: 5},
  },
  components: {
    FileUpload,
    Img,
    Button
  },
  data() {
    return {
      image: null,
    }
  },
  computed: {
    setAccept() {
      return "image/jpeg, image/png"
    }
  },
  watch: {
    uploadedImage(e) {
      this.$emit('change', {event: e})
    }
  },
  methods: {
    upload(file) {
      if (!file || file.size > parseInt(this.maxFileSize) * 1048576) {
        return;
      }
      const reader = new FileReader();
      reader.onload = e => {
        this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    deleteImage() {
      this.image = null;
      return this.$emit('delete')
    }
  }
}
</script>