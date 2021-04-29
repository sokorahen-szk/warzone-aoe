<template>
  <div>
    <CommonWithRightColumnTemplate>
			<template slot="right">
        <v-card
          flat
          tile
          class="ma-2"
        >
          <v-list dense>
            <v-subheader>基本情報</v-subheader>
            <v-divider />
              <v-list-item-group
                color="primary"
              >
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-badge-account-horizontal-outline</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>プロフィールを見る</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-account-edit-outline</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>プロフィール編集</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-view-list-outline</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>個人レーティング</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-format-list-numbered</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>対戦履歴</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
          </v-list>
          a
        </v-card>
        <Button class="mr-2" label="ログアウト" @click="logout" />
			</template>
			<template slot="container">
				{{getProfile}}
			</template>
    </CommonWithRightColumnTemplate>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Button from '@/components/atoms/Button'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
export default {
  name: 'Mypage',
  components: {
    Button,
    CommonWithRightColumnTemplate
  },
  data() {
    return {
      //
    }
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
  },
  methods: {
    ...mapActions('authStore', ['logout']),
  }
}
</script>
