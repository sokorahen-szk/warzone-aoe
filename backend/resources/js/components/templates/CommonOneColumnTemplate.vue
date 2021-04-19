<template>
  <v-row no-gutters>
    <v-col cols="12">
      <v-sheet
        color="grey lighten-4"
        class="pa-3"
      >
        <slot name="container"></slot>
      </v-sheet>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'CommonOneColumnTemplate',
  data() {
    return {
      //
    }
  }
}
</script>