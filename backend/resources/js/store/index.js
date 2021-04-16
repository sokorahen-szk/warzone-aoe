import Vue from "vue"
import Vuex from "vuex"

// Vuex modules...
import breakpointStore from '@/store/breakpoint'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    breakpointStore
  }
})

export default store