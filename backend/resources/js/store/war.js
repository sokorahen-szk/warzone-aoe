const state = {
  // 全対戦履歴
  allWarHistoryList: {
    value: {},
    totalCount: null,
    totalPage: null
  },
  // ログインユーザーの対戦履歴
  userWarHistoryList: {
    value: {},
    totalCount: null,
    totalPage: null
  },
  // 各プレイヤーの対戦履歴
  playerWarHistoryList: {
    value: {},
    totalCount: null,
    totalPage: null
  },
}
const getters = {
  /**
   * 対戦履歴ページのパラメータ取得
   */
  getAllWarHistoryList: (state) => (page) => {
    return state.allWarHistoryList.value[page]
  },
  getAllTotalPage (state) {
    return state.allWarHistoryList.totalPage
  },
  existAllTargetPage: (state) => (page) => {
    return (page in state.allWarHistoryList.value)
  },
  /**
   * ログインユーザーの対戦履歴ページのパラメータ取得
   */
  getUserWarHistoryList: (state) => (page) => {
    return state.userWarHistoryList.value[page]
  },
  getUserTotalPage (state) {
    return state.userWarHistoryList.totalPage
  },
  existUserTargetPage: (state) => (page) => {
    return (page in state.userWarHistoryList.value)
  },
  /**
   * プレイヤー詳細の対戦履歴ページのパラメータ取得
   */
  getPlayerWarHistoryList: (state) => (params) => {
    const playerKey = params.playerId
    const pageKey = params.page
    return state.playerWarHistoryList.value[playerKey][pageKey]
  },
  getPlayerTotalPage (state) {
    return state.playerWarHistoryList.totalPage
  },
  existPlayerTargetPage: (state) => (params) => {
    const playerKey = params.playerId
    const pageKey = params.page
    if(playerKey in state.playerWarHistoryList.value){
      // ここうまくいってない
      return (pageKey in state.playerWarHistoryList.value[playerKey])
    }else{
      return false
    }
  }
}

const mutations = {
  /**
   * 対戦履歴ページのパラメータ設定
   */
  setAllWarHistoryList (state, warHistoryList) {
    let value = _.orderBy(warHistoryList.value, 'startedAt', 'desc')
    value = _.map(value, warHistory => {
      // 日付と時間に分割
      warHistory.gameStartDate = warHistory.startedAt.split(' ')[0]
      warHistory.gameStartTime = warHistory.startedAt.split(' ')[1]
      // チーム単位でプレイヤーをグループ化
      const playerMemories = _.groupBy(warHistory.playerMemories, 'team')
      warHistory.playerMemories = playerMemories
      return warHistory
    })
    const key = warHistoryList.page
    state.allWarHistoryList.value[key] = value
  },
  setAllTotalPage (state, totalPage) {
    state.allWarHistoryList.totalPage = totalPage
  },
  /**
   * ログインユーザーの対戦履歴ページのパラメータ設定
   */
  setUserWarHistoryList (state, warHistoryList) {
    let value = _.orderBy(warHistoryList.value, 'startedAt', 'desc')
    value = _.map(value, warHistory => {
      // 日付と時間に分割
      warHistory.gameStartDate = warHistory.startedAt.split(' ')[0]
      warHistory.gameStartTime = warHistory.startedAt.split(' ')[1]
      // チーム単位でプレイヤーをグループ化
      const playerMemories = _.groupBy(warHistory.playerMemories, 'team')
      warHistory.playerMemories = playerMemories
      return warHistory
    })
    const key = warHistoryList.page
    state.userWarHistoryList.value[key] = value
  },
  setUserTotalPage (state, totalPage) {
    state.userWarHistoryList.totalPage = totalPage
  },
  /**
   * プレイヤー詳細の対戦履歴ページのパラメータ設定
   */
  setPlayerWarHistoryList (state, warHistoryList) {
    let value = _.orderBy(warHistoryList.value, 'startedAt', 'desc')
    value = _.map(value, warHistory => {
      // 日付と時間に分割
      warHistory.gameStartDate = warHistory.startedAt.split(' ')[0]
      warHistory.gameStartTime = warHistory.startedAt.split(' ')[1]
      // チーム単位でプレイヤーをグループ化
      const playerMemories = _.groupBy(warHistory.playerMemories, 'team')
      warHistory.playerMemories = playerMemories
      return warHistory
    })
    const playerKey = warHistoryList.playerId
    const pageKey = warHistoryList.page
    state.playerWarHistoryList.value[playerKey] = {[pageKey]: value}
  },
  setPlayerTotalPage (state, totalPage) {
    state.playerWarHistoryList.totalPage = totalPage
  }
}

const actions = {
  // 全対戦履歴を取得
  fetchAllWarHistoryList (context, page) {
    return new Promise((resolve, reject) => {
      axios.get('/api/game/history/list', {
        params: {
          page: page
        }
      })
      .then((res) => {
        context.commit('setAllWarHistoryList', {'value': res.data.body.gameHistories, 'page': page})
        context.commit('setAllTotalPage', res.data.body.paginator.totalPage)
        resolve()
      })
      .catch(err => {
        reject(err)
      })
    })
  },
  // ログインユーザーの対戦履歴を取得
  fetchUserWarHistoryList (context, params) {
    return new Promise ((resolve, reject) => {
      axios.get(`/api/player/history/${params.userId}`, {
        params: {
          page: params.page
        }
      })
      .then((res) => {
        context.commit('setUserWarHistoryList', {'value': res.data.body.playerHistories, 'page': params.page})
        context.commit('setUserTotalPage', res.data.body.paginator.totalPage)
        resolve()
      })
      .catch(err => {
        reject(err)
      })
    })
  },
  // 各プレイヤーの対戦履歴を取得
  fetchPlayerWarHistoryList (context, params) {
    return new Promise ((resolve, reject) => {
      axios.get(`/api/player/history/${params.playerId}`, {
        params: {
          page: params.page
        }
      })
      .then((res) => {
        context.commit('setPlayerWarHistoryList', {'value': res.data.body.playerHistories, 'playerId': params.playerId, 'page': params.page})
        context.commit('setPlayerTotalPage', res.data.body.paginator.totalPage)
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