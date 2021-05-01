
const state = {
  players: null,
}
const getters ={
  getPlayers: (state) => {
    return state.players
  }
}
const mutations = {
  setPlayers (state, val) {
    state.players = val.$players
  }
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
}
const playerStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default playerStore