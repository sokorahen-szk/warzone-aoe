<template>
  <span>
    <v-icon
      :color="color"
      :size="size"
      v-if="path || href"
      @click="clickEvent"
    >
      <slot></slot>
    </v-icon>
    <v-icon
      :color="color"
      :size="size"
      v-else
    >
      <slot></slot>
    </v-icon>
  </span>
</template>

<script>
import router from '@/router/index'
export default {
  name: 'Icon',
  props: {
    path: {type: String, default: null},
    href: {type: String, default: null},
    color: {type: String, default: ''},
    size: {type: [String, Number], default: 32},
  },
  data() {
    return {

    }
  },
  methods: {
    clickEvent() {
      if (this.path) {
        router.push({path: this.path})
      } else if (this.href) {
        location.href = this.href
      }
    }
  }
}
</script>
