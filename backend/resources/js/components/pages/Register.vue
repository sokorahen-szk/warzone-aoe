<template>
  <v-container>
    <CommonOneColumnTemplate>
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
                        <TextInput
                          :value="userName"
                          @update="userName = $event"
                          placeholder="ユーザ名はログインに使用します"
                          outlined
                          required
                          color="#eee"
                          :rules="{label:'ユーザ名', types:'required,min:4,max:10'}"
                        />
                      </v-col>
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">プレイヤー名<RequireLabel /></div>
                        <TextInput
                          :value="playerName"
                          @update="playerName = $event"
                          placeholder="プレイヤー名はWarzoneのレートページで使用します"
                          outlined
                          required
                          color="#eee"
                          :rules="{label:'プレイヤー名', types:'required,min:2,max:10'}"
                        />
                      </v-col>
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">パスワード<RequireLabel /></div>
                        <PasswordTextInput
                          :value="password"
                          @update="password = $event"
                          placeholder="password"
                          outlined
                          required
                          color="#eee"
                          :rules="{label:'パスワード', types:'required,min:8'}"
                        />
                      </v-col>
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">パスワード再入力<RequireLabel /></div>
                        <PasswordTextInput
                          :value="passwordConfirm"
                          @update="passwordConfirm = $event"
                          placeholder="passwordConfirm"
                          outlined
                          required
                          color="#eee"
                          :rules="{label:'パスワード再入力', types:`required,min:8,confirm:${password}`}"
                        />
                      </v-col>
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">メールアドレス</div>
                        <TextInput
                          :value="email"
                          @update="email = $event"
                          placeholder="email"
                          outlined
                          color="#eee"
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
                      <v-col cols="12" class="text-center mt-2">
                        <Button
                          label="新規登録"
                          color="success"
                          @click="registerEvent"
                          :disabled="!valid"
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
  </v-container>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import RequireLabel from '@/components/atoms/RequireLabel'
import TextInput from '@/components/atoms/TextInput'
import PasswordTextInput from '@/components/atoms/PasswordTextInput'
import Button from '@/components/atoms/Button'
import GamePackage from '@/components/organisms/GamePackage'
import RadioBoxList from '@/components/molecules/RadioBoxList'
import CheckBoxList from '@/components/molecules/CheckBoxList'
import { gamePackages, question1, question2, question3 } from '@/config/register'

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
  },
  data() {
    return {
      valid: true,
      userName: null,
      playerName: null,
      password: null,
      passwordConfirm: null,
      email: null,
      gamePackage: [],
      answer1: null,
      answers2: null,
      // config bind...
      gamePackages: gamePackages,
      question1: question1,
      question2: question2,
      question3: question3,
    }
  },
  methods: {
    registerEvent() {
      if(!this.$refs.form.validate()) return;
      console.log("新規作成処理")
    }
  }
}
</script>