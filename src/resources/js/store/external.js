const state = {
  prefectureName: 'aaa'
}

const getters = {}

const mutations = {}

const actions = {
  async currentLocation(context, latAndLong) {
    console.log(latAndLong)
    const response = await axios.post('/api/external/geo-db-cities', latAndLong)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}