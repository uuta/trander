import {
    OK
} from '../util'

const state = {
  cityName: null,
  lat: null,
  lng: null
}

const getters = {}

const mutations = {
  setcityName(state, cityName) {
    state.cityName = cityName
  },
  setLat(state, lat) {
    state.lat = lat
  },
  setLng(state, lng) {
    state.lng = lng
  },
}

const actions = {
  async currentLocation(context, latAndLong) {
    const response = await axios.post('/api/external/geo-db-cities', latAndLong)
    const city = response.data.data.data[0].city
    const lat = response.data.data.data[0].latitude
    const lng = response.data.data.data[0].longitude
    if (response.status === OK) {
      context.commit('setcityName', city)
      context.commit('setLat', lat)
      context.commit('setLng', lng)
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