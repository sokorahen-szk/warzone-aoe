import { userTemplate } from '@/config/user'
import { excludeNullParams } from '@/services/api_helper';

const state = {
  user: userTemplate,
}
const getters ={
  getProfile: (state) => {
    return state.user
  },
  getUserId: (state) => {
    return state.user.id
  }
}
const mutations = {
  setProfile (state, val) {
    state.user = Object.assign(state.user, val.$user)
  },
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
    return new Promise( (resolve, reject) => {
      axios.post('/api/auth/register', excludeNullParams(payload)).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
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