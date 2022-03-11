import { excludeNullParams } from '@/services/api_helper';

const state = {
  registerRequests: null,
}
const getters = {
  getRegisterRequests: (state) => {
    return state.registerRequests
  }
}
const mutations = {
  setRegisterRequests (state, val) {
    state.registerRequests = val.$registerRequests
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
  updateRegisterRequest ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post(`/api/admin/request/${payload.registerId}`,{
        status: payload.status,
        remarks: payload.remarks,
      }).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  userList ({ commit }, payload) {
    const params = excludeNullParams({
      page: payload.page,
    })

    return new Promise( (resolve, reject) => {
      axios.get('/api/admin/user', {
        params: params
      }).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve(res.data.messages)
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