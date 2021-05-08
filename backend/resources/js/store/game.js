const state = {
  game: {
    packages: null,
    maps: null,
  }
}
const getters ={

}
const mutations = {

}
const actions = {
  packageList ({ commit, dispatch }) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/game/package/list')
      .then( (res) => {
        if (res.data && res.data.isSuccess) {
          resolve(res.data.body);
        } else {
          reject(res.data.errorMessages);
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