import router from '@/router/index'

const state = {
  token: null,
  alert: {
    show: false,
    type: 'info',
    message: null,
  }
}
const getters ={
  isLogin (state) {
    return !!(state.token)
  },
  getAlert (state) {
    return state.alert
  }
}
const mutations = {
  login (state, payload) {
    state.token = payload.token
  },
  logout (state) {
    state.token = null
  },
  alert(state, payload) {
    state.alert = Object.assign(state.alert, payload)
  }
}
const actions = {
  login ({ commit, dispatch }, payload) {
    axios.post('/api/auth/login', {
      name: payload.name,
      password: payload.password,
    }).then( (res) => {
      if(res.data && res.data.isSuccess) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.body.token}`
        commit('login', {token: res.data.body.token})

        // ユーザ情報取得
        dispatch("accountStore/profile", null , {root: true})

        router.push({path: '/account/dashboard'})
      } else {
        commit('alert', {show: true, type: 'error', message: res.data.errorMessages})
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