const state = {
  v: {
    breakpoint: {
      name: '',
    },
  }
}
const getters ={
  getDeviceType: (state) => {
    console.log(state.v.breakpoint.name)
    switch(state.v.breakpoint.name) {
      case 'lg':
      case 'md':
      default:
        return 'pc'
      case 'sm':
      case 'xs':
        return 'sp'
    }
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