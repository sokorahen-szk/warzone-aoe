<template>
  <v-menu
    v-model="modal"
    :close-on-content-click="false"
    :nudge-right="40"
    transition="scale-transition"
    offset-y
    min-width="auto"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="date"
        :label="label"
        prepend-icon="mdi-calendar"
        readonly
        v-bind="attrs"
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker
      v-model="date"
      @input="modal = false"
    ></v-date-picker>
  </v-menu>
</template>

<script>
export default {
  name: 'CalendarInput',
  props: {
    label: {type: String, default: ''},
  },
  data() {
    return {
      modal: false,
      date: '',
    }
  },
  watch: {
    date(value) {
      return this.$emit('update', value)
    }
  }
}
</script>