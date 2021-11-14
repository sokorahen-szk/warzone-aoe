const state = {
  game: {
    packages: null,
    maps: null,
    rules: null,
  }
}
const getters ={
  getPackageList: (state) => {
    return state.game.packages
  },
  getMapList: (state) => {
    return state.game.maps
  },
  getRuleList: (state) => {
    return state.game.rules
  },
}
const mutations = {
  setPackageList (state, val) {
    state.game.packages = val.$packages
  },
  setMapList (state, val) {
    state.game.maps = val.$maps
  },
  setRuleList (state, val) {
    state.game.rules = val.$rules
  }
}
const actions = {
  packageList ({ commit }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/game/package/list')
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          commit('setPackageList', {$packages: res.data.body.gamePackages})
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  mapList({ commit }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/game/map/list')
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          commit('setMapList', {$maps: res.data.body.gameMaps})
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  ruleList({ commit }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/game/rule/list')
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          commit('setRuleList', {$rules: res.data.body.gameRules})
          resolve()
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  teamDivision({ commit }, payload) {
    return new Promise( (resolve, reject) => {
      axios.post('/api/game/create/team_division', {
        'player_ids': payload.playerIds,
        'game_package_id': payload.gamePackageId,
        'rule_id': payload.gameRuleId,
        'map_id': payload.gameMapId,
      })
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          resolve(res.data.body.divisions)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  }
}
const gameStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default gameStore