// export default {
//   namespaced :true,
//   state:  {
//     warHistoryList: []
//   },

//   getters: {
//     getWarHistoryList (state) {
//       return state.warHistoryList;
//     }
//   },

//   mutations: {
//     setWarHistoryList (state, warHistoryList) {
//       state.warHistoryList = warHistoryList
//     }
//   },

//   actions: {
//     fetchWarHistoryList (context) {
//       return new Promise( (resolve, reject) => {
//         axios.get('/api/game/history/list')
//         .then((res) => {
//           context.commit('setWarHistoryList', res.body.gameHistories)
//           resolve()
//         })
//         .catch(err => {
//           reject(err)
//         })
//       })
//     }
//   }
// }

const state = {
  warHistoryList: []
}
const getters = {
  getWarHistoryList (state) {
    return _.map(state.warHistoryList, warHistory => {
      warHistory.gameStartDate = warHistory.startedAt.split(' ')[0]
      warHistory.gameStartTime = warHistory.startedAt.split(' ')[1]
      const playerMemories = _.groupBy(warHistory.playerMemories, 'team')
      warHistory.playerMemories = playerMemories
      return warHistory
    })
  },
  // チーム毎に分割したオブジェクトにする
}

const mutations = {
  setWarHistoryList (state, warHistoryList) {
    state.warHistoryList = _.orderBy(warHistoryList, 'startedAt', 'desc')
  }
}

const actions = {
  fetchWarHistoryList (context) {
    return new Promise( (resolve, reject) => {
      axios.get('/api/game/history/list')
      .then((res) => {
        context.commit('setWarHistoryList', res.data.body.gameHistories)
        resolve()
      })
      .catch(err => {
        reject(err)
      })
    })
  }
}

const warStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}

export default warStore