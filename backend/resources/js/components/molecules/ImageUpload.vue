<template>
  <div>
    <FileUpload :accept="setAccept" @update="view" :disabled="disabled">
      <v-card outlined tile :color="setColor">
        <v-row justify="center" align-content="center" style="height: 200px;">
          <v-icon size="32" v-if="!setImage">mdi-camera-plus-outline</v-icon>
          <div class="pa-2">
            <Img
                v-if="setImage"
                :styles="{
                  'max-height': '200px',
                  'min-height': '200px',
                  'min-width': '60px'
                }"
                :src="setImage"
                thumbnail
            />
          </div>
        </v-row>
      </v-card>
    </FileUpload>
    <div class="py-2 text-center">
      <Button
        v-if="setImage && !disabled"
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
    imagePath: {type: String, default: null},
    disabled: {type: Boolean, default: false},
  },
  components: {
    FileUpload,
    Img,
    Button
  },
  data() {
    return {
      image: null,
      tmpImagePath: this.imagePath,
    }
  },
  watch: {
    imagePath(value) {
      this.tmpImagePath = value;
    }
  },
  computed: {
    setAccept() {
      return "image/jpeg, image/png"
    },
    setImage() {
      return this.image || this.tmpImagePath
    },
    setColor() {
      return this.disabled ? '#ddd' : ''
    }
  },
  methods: {
    view(file) {
      if (!file || file.size > parseInt(this.maxFileSize) * 1048576) {
        return;
      }
      const reader = new FileReader();
      reader.onload = e => {
        this.image = e.target.result;

        this.$emit('upload', file)
      };
      reader.readAsDataURL(file);
    },
    deleteImage() {
      this.image = null;
      this.tmpImagePath = null;
      return this.$emit('delete')
    }
  }
}
</script>