<template>
  <v-container>
    <Alert :properties="alert" dense />
    <CommonOneColumnTemplate elevation="2">
			<template slot="container">
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
        >

          <v-row no-gutters>
            <v-col cols="12">
              <v-row no-gutters justify="center" align-content="center" style="height: 500px;">

                <v-row no-gutters>
                  <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
                  <v-col cols="12" sm="6" md="6" lg="6" xl="6">


                    <div class="text-center my-4 headline">ログイン</div>
                    <v-divider class="py-2" />

                    <v-row class="mt-4">
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">ユーザ名</div>
                        <TextInput
                          :value="userName"
                          @update="userName = $event"
                          placeholder="username"
                          outlined
                          required
                          :rules="{label:'ユーザ名', types:'required,min:4,max:10'}"
                        />
                      </v-col>
                      <v-col cols="12" class="py-0 ma-0">
                        <div class="py-2">パスワード</div>
                        <PasswordTextInput
                          :value="password"
                          @update="password = $event"
                          placeholder="password"
                          outlined
                          required
                          :rules="{label:'パスワード', types:'required,min:8'}"
                        />
                      </v-col>
                      <v-col cols="12" class="text-center mt-2">
                        <Button
                          label="ログイン"
                          color="success"
                          @click="loginEvent"
                          :disabled="!valid"
                          height="65"
                          width="200"
                          font-size="22"
                        />
                      </v-col>

                      <v-col cols="12 text-center">
                        <Link path="passowrd/reset">パスワードをお忘れの方はこちら</Link>
                      </v-col>
                    </v-row>

                  </v-col>
                  <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
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
import TextInput from '@/components/atoms/TextInput'
import Button from '@/components/atoms/Button'
import PasswordTextInput from '@/components/atoms/PasswordTextInput'
import Link from '@/components/atoms/Link'
import Alert from '@/components/atoms/Alert'
import router from '@/router/index'
import { mapActions, mapGetters } from 'vuex'
import { alertTemplate } from '@/config/global'
export default {
  name: 'Login',
  components: {
    CommonOneColumnTemplate,
    TextInput,
    PasswordTextInput,
    Button,
    Link,
    Alert,
  },
  data() {
    return {
      valid: true,
      userName: null,
      password: null,
      alert: alertTemplate,
    }
  },
  computed: {
    ...mapGetters('authStore', ['isLogin']),
  },
  methods: {
    ...mapActions('authStore', ['login']),
    loginEvent() {
      if(!this.$refs.form.validate()) return;
      new Promise((resolve) => {
        resolve(this.login({name: this.userName, password: this.password}))
      })
      .then( () => {
        router.push({path: '/account/mypage'})
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