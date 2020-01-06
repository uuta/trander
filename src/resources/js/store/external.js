const state = {
  prefectureName: 'aaa'
}

const getters = {}

const mutations = {}

const actions = {
  async register(context, data) {
    const response = await axios.post('/api/external/resas', data)
    context.commit('setUser', response.data)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}