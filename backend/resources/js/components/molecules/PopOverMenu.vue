<template>
  <div class="text-center">
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="200"
      offset-x
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="indigo"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Menu
        </v-btn>
      </template>

      <v-card>
      </v-card>
    </v-menu>
  </div>
</template>

<script>
export default {
	name: 'PopOverMenu',
	data() {
		return {
			fav: true,
			menu: false,
			message: false,
			hints: true,
		}
	}
}
</script>
