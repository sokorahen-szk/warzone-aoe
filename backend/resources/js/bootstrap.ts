import Axios, { AxiosStatic } from 'axios'
import Lodash from 'lodash'

declare global {
  interface Window {
    axios: AxiosStatic
    _: any
  }
}

export default function bootstrap() {
  window.axios = Axios
  window._ = Lodash

  window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
  }

  let apiAccessToken: string|null  = null
  if (window.sessionStorage['wzn']) {
    const storage: any = JSON.parse(window.sessionStorage['wzn'])
    if (storage) {
      apiAccessToken = storage.authStore.token
    }

    if (apiAccessToken) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${apiAccessToken}`
    }
  }
}
