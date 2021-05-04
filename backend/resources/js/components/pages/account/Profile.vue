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
              <div class="py-2">ユーザID</div>
              <div class="mb-4">{{ profileView.id }}</div>
            </v-col>

            <v-col cols="12" class="py-0 ma-0">
              <div class="py-2">ユーザ名<RequireLabel /></div>
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

            <v-col cols="12" class="py-0 mb-4" v-show="!editPassword">
              <div class="py-2">パスワード</div>
              <Button
                label="パスワードを変更する"
                color="info"
                tile
                :disabled="!editMode"
                @click="editPassword = !editPassword"
              />
            </v-col>

            <v-col cols="12" class="py-0 mb-4" v-show="editPassword">
              <div class="py-2">パスワード<RequireLabel /></div>
              <PasswordTextInput
                v-model="profile.password"
                @update="profile.password = $event"
                placeholder="password"
                outlined
                required
                :rules="{label:'パスワード', types:'required,min:8'}"
              />
            </v-col>

            <v-col cols="12" class="py-0 mb-4" v-show="editPassword">
              <div class="py-2">パスワード再入力<RequireLabel /></div>
              <PasswordTextInput
                v-model="profile.passwordConfirmation"
                @update="profile.passwordConfirmation = $event"
                placeholder="passwordConfirm"
                outlined
                required
                :rules="{label:'パスワード再入力', types:`required,min:8,confirm:${profile.password}`}"
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
              <div class="py-2">Webサイト</div>
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
              @click="updateProfile"
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
import PasswordTextInput from '@/components/atoms/PasswordTextInput'
import RequireLabel from '@/components/atoms/RequireLabel'
import ImageUpload from '@/components/molecules/ImageUpload'
import Link from '@/components/atoms/Link'
import Alert from '@/components/atoms/Alert'
import { profileTemplate, profileViewTemplate } from '@/config/account'
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
    Alert,
    PasswordTextInput,
    RequireLabel
  },
  data() {
    return {
      profileView: profileViewTemplate,
      profile: profileTemplate,
      editMode: false,
      editPassword: false,
      alert: alertTemplate,
    }
  },
  mounted() {
    this.$set(this, 'profile', objCopy(this.profile, this.getProfile))
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile', 'getUserId']),
  },
  methods: {
    ...mapActions('accountStore', ['avatorUpdate', 'avatorDelete', 'changeProfile']),
    updateProfile() {
      new Promise((resolve) => {
        resolve(this.changeProfile({
          user_name: this.profile.name,
          email: this.profile.email,
          password: this.profile.password,
          password_confirmation: this.profile.passwordConfirmation,
          steam_id: this.profile.steamId,
          twitter_id: this.profile.twitterId,
          web_site_url: this.profile.webSiteUrl,
        }))
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