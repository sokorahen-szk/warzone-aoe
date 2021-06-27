<template>
  <v-container :class="{'pa-0 ma-0': device === 'sp'}" class="container">
    <slot name="header"></slot>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="5" lg="4" xl="3" v-if="device != 'sp'" v-show="!zoom">
        <slot name="right"></slot>
      </v-col>
      <v-col cols="12" sm="12" :md="zoom ? 12 : 7" :lg="zoom ? 12 : 8" :xl="zoom ? 12 : 9">
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
    zoom: {type: Boolean, default: false},
  },
  data() {
    return {
    }
  }
}
</script>
