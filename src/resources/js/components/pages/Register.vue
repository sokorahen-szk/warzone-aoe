<template>
  <CommonOneColumnTemplate
    :device="getDeviceType"
    :sheetPaClass="'pa-3'"
  >
    <template slot="container">
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row no-gutters>
          <v-col cols="12">
            <v-row no-gutters justify="center" align-content="center">

              <v-row no-gutters>
                <v-col offset-sm="2" offset-md="2" offset-lg="2" offset-xl="3"></v-col>
                <v-col cols="12" sm="8" md="8" lg="8" xl="6">


                  <div class="text-center my-4 headline">新規登録</div>
                  <v-divider class="py-2" />

                  <v-row class="mt-4">
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">ユーザ名<RequireLabel /></div>
                      <small>ユーザ名はログイン時に使用します。半角英数字４文字以上の16文字以内で入力してください。</small>
                      <TextInput
                        :value="userName"
                        @update="userName = $event"
                        placeholder="username"
                        outlined
                        required
                        :rules="{label:'ユーザ名', types:'required,min:4,max:16'}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">プレイヤー名<RequireLabel /></div>
                      <small>プレイヤー名はサイトのゲームスコアボードで使用します。2文字以上の30文字以内で入力してください。</small>
                      <TextInput
                        :value="playerName"
                        @update="playerName = $event"
                        placeholder="プレイヤー名"
                        outlined
                        required
                        :rules="{label:'プレイヤー名', types:'required,min:2,max:30'}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">パスワード<RequireLabel /></div>
                      <small>パスワードは8文字以上で入力してください。記号は使用可能。</small>
                      <PasswordTextInput
                        :value="password"
                        @update="password = $event"
                        placeholder="パスワード"
                        outlined
                        required
                        :rules="{label:'パスワード', types:'required,min:8'}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">パスワード再入力<RequireLabel /></div>
                      <PasswordTextInput
                        :value="passwordConfirm"
                        @update="passwordConfirm = $event"
                        placeholder="パスワード再入力"
                        outlined
                        required
                        :rules="{label:'パスワード再入力', types:`required,min:8,confirm:${password}`}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">メールアドレス</div>
                      <small>メールアドレスはパスワードを失念時に使用します。入力は必須ではありません。</small>
                      <TextInput
                        :value="email"
                        @update="email = $event"
                        placeholder="メールアドレス"
                        outlined
                        :rules="{label:'メールアドレス', types:''}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 mb-4">
                      <div class="py-2">
                        プレイ経験
                      </div>
                      <GamePackage
                        :game-packages="gamePackages"
                        @update="gamePackage = $event"
                      />
                    </v-col>
                    <v-col cols="12" class="pt-0 pb-0 px-3 ma-0">
                      <div class="py-2">
                        アラビアマップ 8人戦 4 vs 4の経験がありますか？
                      </div>
                      <RadioBoxList
                        :items="question1"
                        @update="answer1 = $event"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">
                        戦術で実践可能な戦術があれば選択してください。
                      </div>
                      <CheckBoxList
                        :items="question2"
                        @update="answers2 = $event"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <div class="py-2">
                        過去に以下のコミュニティーに参加していた場合選択してください。
                      </div>
                      <CheckBoxList
                        :items="question3"
                        @update="answers3 = $event"
                      />
                    </v-col>
                    <v-col cols="12">
                      <Alert :properties="alert" dense />
                    </v-col>
                    <v-col cols="12" class="text-center mt-2">
                      <Button
                        label="新規登録"
                        color="success"
                        @click="registerEvent"
                        :loading="loading"
                        :disabled="!valid"
                        height="65"
                        width="200"
                        font-size="22"
                      />
                    </v-col>
                  </v-row>


                </v-col>
                <v-col offset-sm="2" offset-md="2" offset-lg="2" offset-xl="3"></v-col>
              </v-row>

            </v-row>
          </v-col>
        </v-row>
      </v-form>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import RequireLabel from '@atoms/RequireLabel'
import TextInput from '@atoms/TextInput'
import PasswordTextInput from '@atoms/PasswordTextInput'
import Button from '@atoms/Button'
import GamePackage from '@organisms/GamePackage'
import RadioBoxList from '@molecules/RadioBoxList'
import CheckBoxList from '@molecules/CheckBoxList'
import Alert from '@atoms/Alert'
import router from '@/router/index'
import { gamePackages, question1, question2, question3 } from '@/config/register'
import { mapActions, mapGetters } from 'vuex'
import { toString } from '@/services/api_helper';
import { alertTemplate } from '@/config/global'

export default {
  name: 'Register',
  components: {
    CommonOneColumnTemplate,
    RequireLabel,
    TextInput,
    PasswordTextInput,
    Button,
    GamePackage,
    RadioBoxList,
    CheckBoxList,
    Alert,
  },
  data() {
    return {
      valid: true,
      alert: alertTemplate,
      userName: null,
      playerName: null,
      password: null,
      passwordConfirm: null,
      email: null,
      gamePackage: null,
      answer1: null,
      answers2: [],
      answers3: [],
      // config bind...
      gamePackages: gamePackages,
      question1: question1,
      question2: question2,
      question3: question3,

      loading: false,
    }
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  methods: {
    ...mapActions('accountStore', ['register']),
    registerEvent() {
      if(!this.$refs.form.validate()) return;
      this.loading = true

      new Promise ( reslve => {
        reslve(this.register({
          user_name: this.userName,
          player_name: this.playerName,
          password: this.password,
          password_confirmation: this.passwordConfirm,
          email: this.email,
          game_package: toString(this.gamePackage),
          answer1: this.answer1,
          answers2: toString(this.answers2),
          answers3: toString(this.answers3)
        }))
      })
      .then( () => {
        alert("アカウント登録しました。")

        router.push({path: '/login'})
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
      .finally( () => {
        this.loading = false
      })
    }
  }
}
</script>