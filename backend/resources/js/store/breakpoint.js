const state = {
  v: {
    breakpoint: {
      name: '',
    },
  }
}
const getters ={
  getDeviceType: (state) => {
    switch(state.v.breakpoint.name) {
      case 'lg':
      case 'md':
      default:
        return 'pc'
      case 'sm':
      case 'xs':
        return 'sp'
    }
  },
  getBreakPoint: (state) => {
    return state.v.breakpoint.name;
  }
}
const mutations = {
  setBreakpoint (state, val) {
    state.v = Object.assign(state.v, val)
  }
}
const actions = {
  updateBreakpoint({commit}, payload) {
    return new Promise((resolve) => {
      commit('setBreakpoint', payload.$vuetify)
      resolve()
    })
  }
}
const breakpointStore = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
export default breakpointStore