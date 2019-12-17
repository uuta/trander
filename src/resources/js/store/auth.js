const state = {
    user: null
}

const getters = {
    check: state => !! state.user,
    username: state => state.user ? state.user.name : ''
}

const mutations = {
    setUser(state, user) {
        state.user = user
    }
}

const actions = {
    async register(context, {
        data,
        router
    }) {
        const response = await axios.post('/api/register', data)
        context.commit('setUser', response.data)
        router.push('/index')
    },
    async login(context, {
        data,
        router
    }) {
        const response = await axios.post('/api/login', data)
        context.commit('setUser', response.data)
        router.push('/index')
    },
    async logout(context, router) {
        await axios.post('/api/logout')
        context.commit('setUser', null)
        router.push('/login')
    },
    async currentUser(context) {
        const response = await axios.get('/api/user')
        const user = response.data || null
        context.commit('setUser', user)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}