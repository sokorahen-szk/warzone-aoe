<template>
  <CommonOneColumnTemplate
    :device="getDeviceType"
    :sheetPaClass="'pa-3'"
  >
    <template slot="header">
      <Alert :properties="alert" dense />
    </template>
    <template slot="container">
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row no-gutters v-if="isValidToken">
          <v-col cols="12">
            <v-row no-gutters justify="center" align-content="center" style="height: 500px;">
              <v-row no-gutters>
                <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
                <v-col cols="12" sm="6" md="6" lg="6" xl="6">

                  <div class="text-center my-4 headline">パスワード再設定</div>
                  <v-divider class="py-2" />

                  <v-row class="mt-4">
                    <v-col cols="12" class="py-0 ma-0">
                      <PasswordTextInput
                        :value="password"
                        @update="password = $event"
                        placeholder="password"
                        outlined
                        required
                        :rules="{label:'パスワード', types:'required,min:8'}"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0 ma-0">
                      <PasswordTextInput
                        :value="passwordConfirm"
                        @update="passwordConfirm = $event"
                        placeholder="パスワード再入力"
                        outlined
                        required
                        :rules="{label:'パスワード再入力', types:`required,min:8,confirm:${password}`}"
                      />
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12" class="text-center">
                      <Button
                        label="再設定する"
                        color="success"
                        @click="update"
                        :disabled="!valid"
                        :loading="loading"
                        height="65"
                        width="200"
                        font-size="22"
                      />
                    </v-col>
                  </v-row>

                </v-col>
                <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
              </v-row>
            </v-row>
          </v-col>
        </v-row>
        <v-row no-gutters v-else>
          <v-col cols="12">
            パスワード再設定のトークンが無効です。
          </v-col>
        </v-row>
      </v-form>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import Alert from '@atoms/Alert'
import Button from '@atoms/Button'
import PasswordTextInput from '@atoms/PasswordTextInput'
import { mapActions, mapGetters } from 'vuex'
import { alertTemplate } from '@/config/global'
import router from '@/router/index'
export default {
	name: 'PasswordResetConfirm',
  components: {
      CommonOneColumnTemplate,
      Alert,
      PasswordTextInput,
      Button,
  },
  data() {
    return {
      alert: alertTemplate,
      isValidToken: false,
      valid: true,
      loading: false,

      token: this.$route.params['token'],
      password: null,
      passwordConfirm: null,
    }
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  mounted() {
    this.checkToken()
  },
  methods: {
    ...mapActions('accountStore', ['passwordResetConfirm']),
    checkToken() {
      if (this.token && this.token.length == 64) {
        this.isValidToken = true
      }
    },
    update() {
      if(!this.$refs.form.validate()) return
      this.loading = true
      new Promise((resolve) => {
        resolve(this.passwordResetConfirm({
          token: this.token,
          password: this.password,
          password_confirmation: this.passwordConfirm,
        }))
      })
      .then( () => {
        alert("パスワード再設定が完了しました。")
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

        router.push({path: '/login'})
      })
    },
  },
}
</script>