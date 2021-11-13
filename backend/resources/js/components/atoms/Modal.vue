<template>
    <v-dialog
        v-model="dialog"
        persistent
        :max-width="`${width}%`"
    >
      <v-card tile>
        <v-container>
          <v-card-title class="pa-0 ma-0">
            <span>{{ title }}</span>
            <v-spacer></v-spacer>
            <v-icon @click="close">mdi-close</v-icon>
          </v-card-title>
          <div class="pt-2">
            <slot></slot>
          </div>
        </v-container>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    title: {type: String},
    show: {type: Boolean, default: false},
    width: {type: [Number, String], default: 80},
  },
  data() {
    return {
        dialog: false,
        notifications: false,
        sound: true,
        widgets: false,
    }
  },
  methods: {
    close() {
      this.dialog = false
      this.$emit('update', false)
    }
  },
  watch: {
    show(v) {
      this.dialog = v
    }
  },
}
</script>