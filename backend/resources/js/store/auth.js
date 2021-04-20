import router from '@/router/index'

const state = {
  token: null,
}
const getters ={
  isLogin (state) {
    return !!(state.token)
  }
}
const mutations = {
  login (state, payload) {
    state.token = payload.token
  },
  logout (state) {
    state.token = null
  }
}
const actions = {
  login ({ commit }, payload) {
    axios.post('/api/auth/login', {
      name: payload.name,
      password: payload.password,
    }).then( (res) => {
      if(res.data || res.data.isSuccess) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.body.token}`
        commit('login', {token: res.data.body.token})

        router.push({path: '/account/dashboard'})
      }
    })
  },
  logout ({ commit }) {
    axios.post('/api/auth/logout')
    .then( (res) => {
      if (res.data) {
        commit('logout')

        router.push({path: '/'})
      }
    })
  }
  /*
  updateBreakpoint({commit}, payload) {
    return new Promise((resolve) => {
      commit('setBreakpoint', payload.$vuetify)
      resolve()
    })
  }
  */
}
const authStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default authStore