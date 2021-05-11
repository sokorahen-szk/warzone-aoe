import {registerRequestTemplate} from '@/config/admin'
const state = {
  registerRequests: [registerRequestTemplate],
}
const getters = {
  getRegisterRequests: (state) => {
    return state.registerRequests
  }
}
const mutations = {
  setRegisterRequests (state, val) {
    state.registerRequests = Object.assign(state.registerRequests, val.$registerRequests)
  }
}
const actions = {
  registerRequest ({ commit }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/admin/request').then( (res) => {
        if(res.data && res.data.isSuccess) {
          commit('setRegisterRequests', {$registerRequests: res.data.body.registerRequests})
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
}
const adminStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default adminStore