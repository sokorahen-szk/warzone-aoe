<template>
  <v-container>
    <Alert :properties="alert" dense />
    <CommonWithRightColumnTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
        <v-row no-gutters>
          <v-col cols="12" sm="12" md="12" lg="6">
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
              <div class="py-2">Twitter</div>
              <TextInput
                v-model="profile.twitterId"
                @update="profile.twitterId = $event"
                placeholder=""
                outlined
                :disabled="!editMode"
                :rules="{label:'twitterId', types:''}"
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

          </v-col>
          <v-col cols="12" sm="12" md="12" lg="6" class="pa-2">
            <div>プロフィール画像</div>
            <ImageUpload
              :imagePath="profile.avatorImage"
              @upload="uploadImage"
              @delete="deleteImage"
              :disabled="!editMode"
            />
          </v-col>
          <v-col cols="12" class="py-2 ma-0 text-center">
            <Button
              v-if="!editMode"
              color="secondary"
              label="編集する"
              iconType="mdi-pencil"
              icon
              :width="200"
              :height="45"
              @click="editMode = !editMode"
            />
            <Button
              v-if="editMode"
              color="info"
              label="保存"
              :width="200"
              :height="45"
              iconType="mdi-content-save"
              icon
            />
          </v-col>
        </v-row>
        <div class="py-2 text-right">
          <Link :path="`/player/${getUserId}`">公開されたページを見る</Link>
        </div>
			</template>
    </CommonWithRightColumnTemplate>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { alertTemplate } from '@/config/global'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import Button from '@/components/atoms/Button'
import TextInput from '@/components/atoms/TextInput'
import ImageUpload from '@/components/molecules/ImageUpload'
import Link from '@/components/atoms/Link'
import Breadcrumbs from '@/components/molecules/Breadcrumbs'
import Alert from '@/components/atoms/Alert'
import {profileTemplate} from '@/config/account'
import {objCopy} from '@/services/helper'
export default {
  name: 'AccountProfile',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    TextInput,
    Button,
    ImageUpload,
    Link,
    Breadcrumbs,
    Alert
  },
  data() {
    return {
      profile: profileTemplate,
      editMode: false,
      alert: alertTemplate,
    }
  },
  mounted() {
    this.$set(this, 'profile', objCopy(this.profile, this.getProfile))
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile', 'getUserId']),
  },
  methods: {
    ...mapActions('accountStore', ['avatorUpdate', 'avatorDelete']),
    uploadImage(e) {
      new Promise((resolve) => {
        resolve(this.avatorUpdate({file: e}))
      })
      .then( (res) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'info',
          message: res,
        })
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
    },
    deleteImage() {
      new Promise((resolve) => {
        resolve(this.avatorDelete())
      })
      .then( (res) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'info',
          message: res,
        })
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
    }
  }
}
</script>