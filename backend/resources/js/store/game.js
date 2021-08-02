const state = {
  game: {
    packages: null,
    maps: null,
  }
}
const getters ={
  getPackageList: (state) => {
    return state.game.packages
  },
  getMapList: (state) => {
    return state.game.maps
  },
}
const mutations = {
  setPackageList (state, val) {
    state.game.packages = val.$packages
  },
  setMapList (state, val) {
    state.game.maps = val.$maps
  }
}
const actions = {
  packageList ({ commit, dispatch }) {
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
  mapList({ commit, dispatch }) {
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