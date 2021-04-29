<template>
  <div>
    <CommonWithRightColumnTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
        <v-row no-gutters>
          <v-col cols="12" sm="12" md="8" lg="6">
            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">ユーザ名</div>
              {{test}}
              <TextInput
                v-model="profile.name"
                @update="profile.name = $event"
                placeholder="username"
                outlined
                required
                color="#eee"
                :disabled="!editMode"
                :rules="{label:'ユーザ名', types:'required,min:4,max:10'}"
              />
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">SteamID</div>
              <TextInput
                v-model="profile.steamId"
                @update="profile.steamId = $event"
                placeholder="steamId"
                outlined
                required
                color="#eee"
                :disabled="!editMode"
                :rules="{label:'steamId', types:'required,min:4,max:10'}"
              />
            </v-col>

          </v-col>
        </v-row>
			</template>
    </CommonWithRightColumnTemplate>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import TextInput from '@/components/atoms/TextInput'
import {profileTemplate} from '@/config/account'
import {objCopy} from '@/services/helper'
export default {
  name: 'AccountProfile',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    TextInput
  },
  data() {
    return {
      profile: profileTemplate,
      editMode: false,
      test: null,
    }
  },
  watch: {
  },
  mounted() {
    this.$set(this, 'profile', objCopy(this.profile, this.getProfile))
    // TODO: どう実装するか
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
  },
}
</script>