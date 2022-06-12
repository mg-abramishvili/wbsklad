import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: {}
    },
    getters: {
        user(state) {
            return state.user
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        }
    },
    actions: {
        loadUser() {
            return new Promise((resolve, reject) => {
                axios.post('/api/me')
                .then(response => {
                    resolve(response.data)
                })
            })
        }
    }
})