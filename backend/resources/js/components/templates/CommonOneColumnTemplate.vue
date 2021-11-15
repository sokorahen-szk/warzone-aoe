<template>
  <v-container :class="{'pa-0 ma-0': device === 'sp'}">
    <slot name="header"></slot>
    <v-row no-gutters>
      <v-col cols="12">
        <v-sheet
          :color="backGround"
          :class="sheetPaClass"
          :elevation="elevation"
        >
          <slot name="container"></slot>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ComponentTemplate from '@/components/ComponentTemplate'

export default {
  name: 'CommonOneColumnTemplate',
  extends: ComponentTemplate,
  props: {
    backGround: {type: String, default: '#eee'},
    elevation: {type: [String, Number], default: 0},
    device: {type: String},
    sheetPaClass: {type: String, default: null}
  },
  data() {
    return {
      //
    }
  }
}
</script>