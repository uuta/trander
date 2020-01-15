import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import external from './external'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        external
    }
})

export default store