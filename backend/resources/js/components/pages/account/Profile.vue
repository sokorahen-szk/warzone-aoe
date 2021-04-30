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
              <TextInput
                v-model="profile.name"
                @update="profile.name = $event"
                placeholder=""
                outlined
                required
                :disabled="!editMode"
                :rules="{label:'ユーザ名', types:'required,min:4,max:10'}"
              />
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">メールアドレス</div>
              <TextInput
                v-model="profile.email"
                @update="profile.email = $event"
                placeholder=""
                outlined
                :disabled="!editMode"
                :rules="{label:'email', types:''}"
              />
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">SteamID</div>
              <TextInput
                v-model="profile.steamId"
                @update="profile.steamId = $event"
                placeholder=""
                outlined
                :disabled="!editMode"
                :rules="{label:'steamID', types:''}"
              />
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">My Webサイト</div>
              <TextInput
                v-model="profile.webSiteUrl"
                @update="profile.webSiteUrl = $event"
                placeholder=""
                outlined
                :disabled="!editMode"
                :rules="{label:'webSiteUrl', types:''}"
              />
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <Button
                v-if="!editMode"
                color="secondary"
                label="編集する"
                iconType="mdi-pencil"
                icon
                @click="editMode = !editMode"
              />
              <Button
                v-if="editMode"
                color="info"
                label="保存"
                iconType="mdi-content-save"
                icon
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
import Button from '@/components/atoms/Button'
import TextInput from '@/components/atoms/TextInput'
import {profileTemplate} from '@/config/account'
import {objCopy} from '@/services/helper'
export default {
  name: 'AccountProfile',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    TextInput,
    Button
  },
  data() {
    return {
      profile: profileTemplate,
      editMode: false,
    }
  },
  watch: {
  },
  mounted() {
    this.$set(this, 'profile', objCopy(this.profile, this.getProfile))
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
  },
}
</script>