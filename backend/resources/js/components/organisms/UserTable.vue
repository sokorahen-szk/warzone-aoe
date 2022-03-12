<template>
  <div>
  <slot name="header"></slot>
  <Loading
    class="pa-2"
    size="32"
    v-if="isLoading"
  />
  <v-simple-table v-else>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            ID
          </th>
          <th class="text-left">
            ユーザ名
          </th>
          <th class="text-left">
            ロール
          </th>
          <th class="text-left">
            参加日
          </th>
          <th class="text-left">
            ステータス
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users"
          :key="user.name"
          @click="$emit('clickShow', user.id)"
        >
          <td>{{ user.id }}</td>
          <td>
            <v-avatar
              color="grey lighten-2"
              size="40"
            >
              <img :src="user.avatorImage" />
            </v-avatar>
            {{ user.name }}
          </td>
          <td>{{ user.role.name }}</td>
          <td>{{ user.player.joinedAt }}</td>
          <td>{{ userStatus(user.status) }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
  <Pagination
    :current="currentPage"
    :length="userRecordTotalPage"
    @change="(page) => $emit('changePage', page)"
  />
  </div>
</template>

<script>
import { userStatusLabels } from '@/config/user'
import Pagination from '@atoms/Pagination'
import Loading from '@atoms/Loading'

export default {
  name: 'UserTable',
  components: {
    Pagination,
    Loading,
  },
  props: {
    users: {type: Array},
    currentPage: {type: Number},
    userRecordTotalPage: {type: Number},
  },
  data() {
    return {
      isLoading: true,
    }
  },
  watch: {
    users: {
      handler(value) {
        this.isLoading = value ? false : true
      }, deep: true
    },
  },
  methods: {
    userStatus(status) {
      const userStatusLabel = userStatusLabels.find( (userStatusLabel) => {
        return userStatusLabel.id === status
      })

      return userStatusLabel && userStatusLabel.label
    },
    view(user) {
      console.log(user)
    }
  }
}
</script>
