<template>
  <div>
    ダッシュボード
    <Button class="mr-2" label="ログアウト" @click="logout" />
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import Button from '@/components/atoms/Button'
export default {
  name: 'Dashboard',
  components: {
    Button
  },
  data() {
    return {
      //
    }
  },
  methods: {
    ...mapActions('authStore', ['logout']),
  }
}
</script>
