import { userTemplate } from '@/config/user'
import { excludeNullParams } from '@/services/api_helper';

const state = {
  user: userTemplate,
  raiting: [],
  myGameList: null,
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
  },

  getMyGameList: (state) => {
    return state.myGameList
  },
}
const mutations = {
  setProfile (state, val) {
    state.user = Object.assign(state.user, val.$user)
  },

  setRaiting (state, val) {
    state.raiting = val.$gameRecords
  },

  setmyGameList (state, val) {
    state.myGameList = val.$myGameList
  },

  reset( state ) {
    state.user = userTemplate;
  }
}
const actions = {
  myGameList ({ commit }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/account/games')
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          commit('setmyGameList', {$myGameList: res.data.body.gameRecords})
          resolve(res.data.body.gameRecords)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  myGameStatusUpdate ({ commit }, payload) {
    const params = excludeNullParams({
      status: payload.status,
      winning_team: payload.winningTeam
    })
    return new Promise( (resolve, reject) => {
      axios.post(`/api/account/games/${payload.gameRecordId}`, params)
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
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
  passwordReset ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post('/api/account/password/reset', excludeNullParams(payload)).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  passwordResetConfirm ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post(`/api/account/password/reset/${payload.token}`, excludeNullParams(payload)).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve()
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