<template>
  <v-row no-gutters>
    <v-col cols="12" sm="12" md="7" lg="8" xl="9">
      <slot name="container"></slot>
    </v-col>
    <v-col cols="12" sm="12" md="5" lg="4" xl="3">
      <slot name="left"></slot>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'CommonWithLeftColumnTemplate',
  data() {
    return {
      //
    }
  }
}
</script>
