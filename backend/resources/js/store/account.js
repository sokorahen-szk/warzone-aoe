import { userTemplate } from '@/config/user'
import { excludeNullParams } from '@/services/api_helper';

const state = {
  user: userTemplate,
  raiting: [],
}
const getters ={
  getProfile: (state) => {
    return state.user
  },
  getUserId: (state) => {
    return state.user.id
  },
  getRaiting: (state) => {
    return state.raiting
  }
}
const mutations = {
  setProfile (state, val) {
    state.user = Object.assign(state.user, val.$user)
  },

  setRaiting (state, val) {
    state.raiting = Object.assign(state.raiting, val.$gameRecords)
  },

  reset( state ) {
    state.user = userTemplate;
  }
}
const actions = {
  profile ({ commit }) {
    axios.get('/api/account/profile')
    .then( (res) => {
      if(res.data && res.data.isSuccess) {
        commit('setProfile', {$user: res.data.body})
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
  },
  avatorUpdate ({ commit, dispatch }, payload) {
    const params = new FormData();
    params.append('file', payload.file)
    return new Promise( (resolve, reject) => {
      axios.post('/api/account/avator/edit', params).then( (res) => {
        if(res.data && res.data.isSuccess) {

          dispatch("accountStore/profile", null , {root: true})

          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  avatorDelete ({ commit, dispatch }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post('/api/account/avator/delete').then( (res) => {
        if(res.data && res.data.isSuccess) {

          dispatch("accountStore/profile", null , {root: true})

          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  changeProfile ({ commit, dispatch }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post('/api/account/profile/edit', excludeNullParams(payload)).then( (res) => {
        if(res.data && res.data.isSuccess) {

          dispatch("accountStore/profile", null , {root: true})

          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },

  withdrawal ({ commit, dispatch }) {
    return new Promise( (resolve, reject) => {
      axios.post('/api/account/withdrawal').then( (res) => {
        if(res.data && res.data.isSuccess) {

          dispatch("authStore/stateReset", null , {root: true})
          commit('reset')

          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },

  raiting ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/account/raiting', { params: excludeNullParams(payload) }).then( (res) => {
        if(res.data && res.data.isSuccess) {

          commit('setRaiting', {$gameRecords: res.data.body.gameRecords})
          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },

  stateReset ({commit}) {
    commit('reset')
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