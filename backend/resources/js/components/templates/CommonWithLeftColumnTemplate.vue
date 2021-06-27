<template>
  <v-container :class="{'pa-0 ma-0': device === 'sp'}" class="container">
    <slot name="header"></slot>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="7" lg="8" xl="9">
        <slot name="container"></slot>
      </v-col>
      <v-col cols="12" sm="12" md="5" lg="4" xl="3">
        <slot name="left"></slot>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'CommonWithLeftColumnTemplate',
  props: {
    backGround: {type: String, default: 'grey lighten-4'},
    elevation: {type: [String, Number], default: 0},
    device: {type: String},
  },
  data() {
    return {
      //
    }
  }
}
</script>
