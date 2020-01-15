import {
    OK
} from '../util'

const state = {
  cityName: null,
  lat: null,
  lng: null,
  currentLat: null,
  currentLng: null,
  seeLat: null,
  seeLng: null,
  icon: false,
  modal: false,
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
  setCurrentLat(state, currentLat) {
    state.currentLat = currentLat
  },
  setCurrentLng(state, currentLng) {
    state.currentLng = currentLng
  },
  setSeeLat(state, seeLat) {
    state.seeLat = seeLat
  },
  setSeeLng(state, seeLng) {
    state.seeLng = seeLng
  },
  setIcon(state, icon) {
    state.icon = icon
  },
  setModal(state, modal) {
    state.modal = modal
  },
}

const actions = {
  async setNewLocation(context, latAndLong) {
    const responseDatas = await axios.post('/api/external/geo-db-cities', latAndLong)
    const responseData = responseDatas.data.data.data[0]
    const city = responseData.city
    const lat = responseData.latitude
    const lng = responseData.longitude

    if (responseDatas.status === OK) {
      context.commit('setcityName', city)
      context.commit('setLat', lat)
      context.commit('setLng', lng)
      context.commit('setSeeLat', lat)
      context.commit('setSeeLng', lng)
      context.commit('setIcon', true)
      context.commit('setModal', true)
    }

    // TODO: エラーハンドリングしたい
  }
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}