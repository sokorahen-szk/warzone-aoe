<template>
  <router-link :to="path" class="link"><slot></slot></router-link>
</template>

<style scoped>
.link {
}
.link:hover {
  color: #87cefa;
  text-decoration: none;
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