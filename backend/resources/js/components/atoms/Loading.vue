<template>
  <div class="text-center">
    <v-progress-circular
      indeterminate
      color="#aaa"
      :size="size"
    ></v-progress-circular>
  </div>
</template>

<script>
export default {
  name: 'Loading',
  props: {
    size: {type: [Number, String]},
  }
}
</script>
