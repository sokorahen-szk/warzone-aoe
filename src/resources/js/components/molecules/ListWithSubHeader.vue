<template>
  <v-card
    flat
    tile
  >
    <v-list dense>
      <v-subheader v-if="subHeader">{{ subHeader }}</v-subheader>
      <v-divider />
        <v-list-item-group
          color="primary"
        >
          <v-list-item v-for="list in lists" :key="list.label" :to="list.path">
            <v-list-item-icon>
              <v-icon>{{ list.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ list.label }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
    </v-list>
  </v-card>
</template>

<script>
export default {
  name: 'ListWithSubHeader',
  props: {
    subHeader: {type: String, default: null},
    lists: {type: Array, default: []},
  },
  data() {
    return {
    }
  }
}
</script>