<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Name
          </th>
          <th class="text-left">
            Calories
          </th>
          <th class="text-left">
            Calories
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item.name"
        >
          <td>
            <v-avatar
              color="grey lighten-2"
              size="40"
            >
              <img :src="item.avatorImage" />
            </v-avatar>
            {{ item.name }}
          </td>
          <td>{{ item.calories }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
export default {
  name: 'UserTable',
  props: {
    items: {type: Array}
  }
}
</script>
