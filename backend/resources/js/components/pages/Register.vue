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
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">
                          アラビアマップ 8人戦 4 vs 4の経験がありますか？
                        </div>
                        <RadioBox
                          :items="questionnaires1"
                          @update="questionnaire = $event"
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
import RadioBox from '@/components/molecules/RadioBox'
export default {
  name: 'Register',
  components: {
    CommonOneColumnTemplate,
    RequireLabel,
    TextInput,
    PasswordTextInput,
    Button,
    GamePackage,
    RadioBox
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
      questionnaire: null,
      gamePackages: [
        {
          id: 1,
          image: 'https://lh6.googleusercontent.com/cLcyfKRL-JGGGCVBs5f1wRBqb2PE2bCCKzXZgID-SPlhjfh2wKUbGNijRoBeZPRDWrZq0MiAxdj0HsCAMJN9vnU2GTuGjQTi1sm3uo7DhjVZHiLbak_diMFSUcDV=w146',
          title: 'Age of Empires II (パッケージ版)',
        },
        {
          id: 2,
          image: 'https://lh5.googleusercontent.com/KKp8UpamlYDrvpWsqWw67KhXLyh6S7GWTo9hpiSbzJi-sMQjYwJVz9DCs4JCafELJ2Qc7d_E1qEpO18YXKUJYWqSYNzKKa9KJhSZvbslzjVdGuZ0Gkna1sjExhom=w260',
          title: 'Age of Empires II HD (steam版)',
        },
        {
          id: 3,
          image: 'https://lh5.googleusercontent.com/Q8B15eV8jA8D6SpowwWxMKr_3ZcDe4CmWXegUVIM2UYwQSUhXPIDq244TNGlLs6LTDbpAVw-2ZxgGkY1b2v4BYXibeU4fhVmHT7hp43mWHQ8NytQVbf5toNnnwN2=w260',
          title: 'Age of Empires II DE (steam版)',
        },
      ],
      questionnaires1: [
        {label: '10戦以上', value: 0},
        {label: '5戦以上', value: 1},
        {label: 'なし', value: 2},
      ],
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