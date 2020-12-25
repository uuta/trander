import Vue from 'vue'
import Vuex from 'vuex'

import common from './common'
import auth from './auth'
import error from './error'
import external from './external'
import kw from './kw'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        common,
        auth,
        error,
        external,
        kw,
    }
})

export default store