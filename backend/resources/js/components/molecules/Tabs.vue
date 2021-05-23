<template>
  <div>
    <v-tabs
      v-model="tab"
      :left="left"
      :centered="centered"
      :right="right"
      :grow="grow"
      @change="changeEvent"
    >
      <v-tabs-slider :color="sliderColor"></v-tabs-slider>
      <v-tab
        v-for="(tab, index) in tabs"
        :key="`tab-${index}`"
      >
        <v-icon
          v-if="tab.icon"
          left
        >
          {{tab.icon}}
        </v-icon>
        {{tab.label}}
      </v-tab>
    </v-tabs>
  </div>
</template>

<script>
export default {
  name: 'Tabs',
  props: {
    left: {type: Boolean, default: false},
    centered: {type: Boolean, default: false},
    right: {type: Boolean, default: false},
    grow: {type: Boolean, default: false},
    sliderColor: {type: String, default: '#424242'},
    tabs: {type: Array, default: []},
    selectedTab: {type: Number, default: 0},
  },
  data() {
    return {
      tab: this.selectedTab,
    }
  },
  methods: {
    changeEvent() {
      return this.$emit('change', this.tab)
    }
  }
}
</script>