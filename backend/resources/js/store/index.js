import Vue from "vue"
import Vuex from "vuex"
import createPersistedState from 'vuex-persistedstate'

// Vuex modules...
import breakpointStore from '@/store/breakpoint'
import authStore from '@/store/auth'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    breakpointStore,
    authStore
  },

  plugins: [createPersistedState(
    {
      key: 'wzn',

      paths: [
      ],

      storage: window.sessionStorage
    }
  )]
})

export default store