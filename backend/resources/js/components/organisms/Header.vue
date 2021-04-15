<template>
  <header>
    <v-app-bar flat dense>
      <v-container class="py-0 fill-height">
      <v-toolbar-title>
        <v-btn
         :to="header.site.home"
         text
         plain
        >
          {{header.site.name}}
        </v-btn>
      </v-toolbar-title>
      <v-spacer />

      <v-btn
        v-for="link in header.links"
        :key="link.label"
        :to="link.uri"
        text
        plain
      >
        {{ link.label }}
      </v-btn>

      </v-container>
    </v-app-bar>
  </header>
</template>

<script>
export default {
  name: "Header",
  props: {
    header: {type: Object, required: true},
  },
  data() {
    return {
      //
    }
  },
}
</script>
