import { excludeNullParams } from '@/services/api_helper';

const state = {
  players: null,
  raiting: [],
  playerProfile: null,
}
const getters ={
  getPlayers: (state) => {
    return state.players
  },
  getPlayerRaitings: (state) => {
    return state.raiting
  },
  getPlayerProfile: (state) => {
    return state.playerProfile
  }
}
const mutations = {
  setPlayers (state, val) {
    state.players = val.$players
  },
  setPlayerRaitings (state, val) {
    state.raiting = val.$gameRecords
  },
  setPlayerProfile (state, val) {
    state.playerProfile = val.$playerProfile
  },
}
const actions = {
  playerList ({ commit }) {
    axios.get('/api/player/list')
    .then( (res) => {
      if(res.data && res.data.isSuccess) {
        commit('setPlayers', {$players: res.data.body.players})
      }
    })
  },
  playerRaitingList ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.get(`/api/player/raiting/${payload.id}`, { params: excludeNullParams(payload.options) }).then( (res) => {
        if(res.data && res.data.isSuccess) {
          commit('setPlayerRaitings', {$gameRecords: res.data.body.gameRecords})
          resolve(res.data.body.gameRecords)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  playerProfile ({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.get(`/api/player/profile/${payload.id}`).then( (res) => {
        if(res.data && res.data.isSuccess) {
          commit('setPlayerProfile', {$playerProfile: res.data.body})
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  }
}
const playerStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default playerStore