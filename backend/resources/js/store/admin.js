import { excludeNullParams } from '@/services/api_helper';

const state = {
  registerRequests: null,

  allUserList: {
    value: null,
    totalCount: null,
    totalPage: null
  }
}
const getters = {
  getRegisterRequests: (state) => {
    return state.registerRequests
  },
  getUsers: (state) => {
    return state.allUserList.value
  },
  getUsersTotalCount: (state) => {
    return state.allUserList.totalCount
  },
  getUsersTotalPage: (state) => {
    return state.allUserList.totalPage
  },
}
const mutations = {
  setRegisterRequests (state, val) {
    state.registerRequests = val.$registerRequests
  },
  setUsers (state, val) {
    state.allUserList.value = val.$users
  },
  setUsersTotalCount (state, val) {
    state.allUserList.totalCount = val.$totalCount
  },
  setUsersTotalPage (state, val) {
    state.allUserList.totalPage = val.$totalPage
  },
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
  listUser ({ commit }, payload) {
    const params = excludeNullParams(payload)
    return new Promise( (resolve, reject) => {
      axios.get('/api/admin/user', {
        params: params
      }).then( (res) => {
        if(res.data && res.data.isSuccess) {
          commit('setUsers', {$users: res.data.body.users})
          commit('setUsersTotalCount', {$totalCount: res.data.body.paginator.totalCount})
          commit('setUsersTotalPage', {$totalPage: res.data.body.paginator.totalPage})
          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  updateUser ({ commit }, payload) {
    const params = excludeNullParams({
      user_name: payload.userName,
      password: payload.password,
      email: payload.email,
      steam_id: payload.steamId,
      twitter_id: payload.twitterId,
      web_site_url: payload.webSiteUrl,
      status: payload.status,
      role_id: payload.roleId,
      game_packages: payload.gamePackages,
    })
    return new Promise( (resolve, reject) => {
      axios.post(`/api/admin/user/${payload.id}`, params).then( (res) => {
        if(res.data && res.data.isSuccess) {
          resolve(res.data.messages)
        } else {
          reject(res.data.errorMessages)
        }
      })
    })
  },
  createUser ({ commit }, payload) {
    const params = excludeNullParams({
      user_name: payload.userName,
      player_name: payload.playerName,
      role_id: payload.roleId,
      password: payload.password,
      steam_id: payload.steamId,
    })
    return new Promise( (resolve, reject) => {
      axios.post(`/api/admin/user/create`, params).then( (res) => {
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