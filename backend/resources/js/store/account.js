import { userTemplate } from '@/config/user'

const state = {
  user: userTemplate
}
const getters ={
  getProfile: (state) => {
    return state.user;
  }
}
const mutations = {
  setProfile (state, val) {
    state.user = Object.assign(state.user, val.$user)
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
}
const accountStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default accountStore