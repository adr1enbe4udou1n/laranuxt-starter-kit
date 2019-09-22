import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export function createStore(app) {
  return new Vuex.Store({
    state: {
      user: app.user
    },
    mutations: {
      setUser(state, user) {
        state.user = user
      }
    },
    actions: {
      async logout() {
        await axios.post(app.route('logout'))
        location.reload()
      }
    }
  })
}
