<template>
  <v-container>
    <v-row no-gutters>
      <v-col cols="12">
        <v-sheet
          :color="backGround"
          class="pa-3"
        >
          <slot name="container"></slot>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'CommonOneColumnTemplate',
  props: {
    backGround: {type: String, default: 'grey lighten-4'},
  },
  data() {
    return {
      //
    }
  }
}
</script>