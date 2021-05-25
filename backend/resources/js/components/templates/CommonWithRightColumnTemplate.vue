<template>
  <v-container :class="{'pa-0 ma-0': device === 'sp'}">
    <slot name="header"></slot>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="5" lg="4" xl="3" v-if="device != 'sp'">
        <slot name="right"></slot>
      </v-col>
      <v-col cols="12" sm="12" md="7" lg="8" xl="9">
        <v-container>
          <v-card
            class="pa-3"
            tile
            :outlined="outlined"
          >
            <slot name="container"></slot>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'CommonWithRightColumnTemplate',
  props: {
    color: {type: String, default: 'grey lighten-4'},
    outlined: {type: Boolean, default: false},
    device: {type: String},
  },
  data() {
    return {
      //
    }
  }
}
</script>
