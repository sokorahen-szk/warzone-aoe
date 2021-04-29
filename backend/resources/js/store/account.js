import { userTemplate } from '@/config/user'
import { excludeNullParams } from '@/services/api_helper';
import router from '@/router/index'

const state = {
  user: userTemplate,
  alert: {
    show: false,
    type: 'info',
    message: null,
  }
}
const getters ={
  getProfile: (state) => {
    return state.user;
  },
  getAlert (state) {
    return state.alert
  }
}
const mutations = {
  setProfile (state, val) {
    state.user = Object.assign(state.user, val.$user)
  },
  alert(state, payload) {
    state.alert = Object.assign(state.alert, payload)
  }
}
const actions = {
  profile ({ commit }) {
    axios.get('/api/account/profile')
    .then( (res) => {
      if(res.data) {
        commit('setProfile', {$user: res.data})
      }
    })
  },
  register ({commit}, payload) {
    axios.post('/api/auth/register', excludeNullParams(payload)).then( (res) => {
      if(res.data && res.data.isSuccess) {
        alert(res.data.messages)

        router.push({path: '/login'})
      } else {
        commit('alert', {show: true, type: 'error', message: res.data.errorMessages})
      }
    })
  }
}
const accountStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default accountStore