<template>
  <v-container>
    <CommonWithRightColumnTransportTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
        <v-card
          class="pa-3 mb-4"
          tile
          outlined
        >
        <v-row no-gutters>
          <v-col cols="12">
            <div class="py-2">ステータス</div>
            <v-divider />
            <v-row no-gutters class="pt-2">
              <v-col cols="6">
                <div>アカウント状態</div>
                <TextMark
                  :value="profileView.status"
                  color="light-green"
                />
              </v-col>
              <v-col cols="6">
                <div>プレイヤー状態</div>
                <Status :value="profileView.player.enabled" />
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        </v-card>

        <v-card
          class="pa-3 mb-4"
          tile
          outlined
        >
          ここにダッシュボードとか？
        </v-card>
			</template>
    </CommonWithRightColumnTransportTemplate>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTransportTemplate from '@/components/templates/CommonWithRightColumnTransportTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import TextMark from '@/components/atoms/TextMark'
import Status from '@/components/atoms/Status'
import {objCopy} from '@/services/helper'
import { profileViewTemplate } from '@/config/account'

export default {
  name: 'AccountMypage',
  components: {
    CommonWithRightColumnTransportTemplate,
    AccountRightMenu,
    TextMark,
    Status
  },
  data() {
    return {
      profileView: profileViewTemplate
    }
  },
  mounted() {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
    })
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
  },
}
</script>
