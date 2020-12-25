import {
    OK,
    CREATED,
    UNPROCESSABLE_ENTITY
} from '../util'

const state = {
    user: null,
    email: null,
    apiStatus: null,
    loginErrorMessages: null,
    registerErrorMessages: null,
    resetErrorMessages: null,
    regenerateErrorMessages: null,
    registerModal: false,
}

const getters = {
    check: state => !! state.user,
    username: state => state.user ? state.user.name : '',
    email: state => state.email ? state.email.email : '',
}

const mutations = {
    setUser(state, user) {
        state.user = user
    },
    setEmail(state, email) {
        state.email = email
    },
    setApiStatus(state, status) {
        state.apiStatus = status
    },
    setLoginErrorMessages(state, messages) {
        state.loginErrorMessages = messages
    },
    setRegisterErrorMessages(state, messages) {
        state.registerErrorMessages = messages
    },
    setResetErrorMessages(state, messages) {
        state.resetErrorMessages = messages
    },
    setRegenerateErrorMessages(state, messages) {
        state.regenerateErrorMessages = messages
    },
    setRegisterModal(state, registerModal) {
        state.registerModal = registerModal
    },
}

const actions = {
    async register(context, {
        data,
        router
    }) {
        context.commit('setApiStatus', null)
        const response = await axios.post('/api/register', data)
        if (response.status === CREATED) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response.data)
            context.commit('setRegisterModal', true)
            router.push('/index')
            return false
        }

        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setRegisterErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, { root: true })
        }
    },
    async login(context, {
        data,
        router
    }) {
        context.commit('setApiStatus', null)
        const response = await axios.post('/api/login', data)

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response.data)
            router.push('/index')
            return false
        }
        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, { root: true })
        }
    },
    async logout(context, router) {
        context.commit('setApiStatus', null)
        const response = await axios.post('/api/logout')

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', null)
            router.push('/login')
            return false
        }
        context.commit('setApiStatus', false)
        context.commit('error/setCode', response.status, { root: true })
    },
    async currentUser(context) {
        context.commit('setApiStatus', null)
        const response = await axios.get('/api/user')
        const user = response.data || null

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', user)
            return false
        }

        context.commit('setApiStatus', false)
        context.commit('error/setCode', response.status, { root: true })
    },
    async checkRegistration(context) {
        const response = await axios.get('/api/user')
        const check = response.data.check_registration || null

        if (response.status === OK) {
            context.commit('setRegisterModal', check)
        }
    },
    async hiddenRegisterModal(context) {
        context.commit('setRegisterModal', false)
        await axios.post('/api/change-registration')
    },
    async resetPassword(context, {
        data,
        router
    }) {
        context.commit('setApiStatus', null)
        const response = await axios.post('/api/reset-password', data)

        if (response.status === OK) {
            context.commit('setEmail', data)
            router.push('/sent-email')
            return false
        }

        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setResetErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, {
                root: true
            })
        }
    },
    async regeneratePassword(context, {
        data,
        router
    }) {
        context.commit('setApiStatus', null)
        data['token'] = router.app._route.params.token
        const response = await axios.post('/api/regenerate-password', data)
        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response.data)
            router.push('/regenerate-password-complete')
            return false
        }

        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setRegenerateErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, {
                root: true
            })
        }
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}