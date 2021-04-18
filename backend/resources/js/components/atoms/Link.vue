<template>
  <router-link :to="path" class="link"><slot></slot></router-link>
</template>

<style scoped lang="scss">
.link {

}
</style>

<script>
export default {
  name: 'Link',
  props: {
    path: {
      path: {type: String},
    }
  },
  data() {
    return {
      //
    }
  }
}
</script>