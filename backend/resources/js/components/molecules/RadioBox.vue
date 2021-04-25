<template>
<v-radio-group v-model="radios">
  <v-radio
    v-for="(index, item) in items"
    :key="item.label"
    :label="item.label"
    :value="item.value"
  ></v-radio>
</v-radio-group>
</template>

<script>
export default {
  name: 'RadioBox',
  data() {
    return {
      radios: [],
      items: [
        {label: "AAAA", value: 0},
        {label: "BBBB", value: 1},
        {label: "CCCC", value: 2},
        {label: "DDDD", value: 3},
      ]
    }
  }
}
</script>