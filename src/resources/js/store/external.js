import {
  OK,
  NO_RECORD
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
  settingModal: false,
  distance: [0, 100],
  errorMessages: null
}

const getters = {}

const mutations = {
  setNewLocation(state, value) {
    state.cityName = value.city
    state.lat = value.latitude
    state.lng = value.longitude
    state.seeLat = value.latitude
    state.seeLng = value.longitude
    state.icon = true
    state.modal = true
  },
  setModal(state, value) {
    state.modal = value
  },
  setSettingModal(state, value) {
    state.settingModal = value
  },
  setDistance(state, value) {
    state.distance = value
  },
  setCurrentLocation(state, value) {
    state.currentLat = value.lat
    state.currentLng = value.lng
    state.seeLat = value.lat
    state.seeLng = value.lng
  },
  setSetting(state, value) {
    state.distance = value
    state.settingModal = false
  },
  setErrorMessages(state, value) {
    state.errorMessages = value
  },
}

const actions = {
  async getLoading(context, latLng) {
    const res = await axios.post('/api/setting')

    // レスポンスが空ではない時の処理
    if (res.status === OK && Object.keys(res.data).length) {
        const distance = [
            res.data.min_distance, res.data.max_distance
        ]
        context.commit('setDistance', distance)
    }
    // レスポンスが空の処理
    if (res.status === OK && !Object.keys(res.data).length) {
        return false;
    }

    context.commit('setCurrentLocation', latLng)
  },
  async setNewLocation(context, { latLng, router }) {
    const res = await axios.post('/api/external/geo-db-cities', latLng)

    // レスポンスが空ではない時の処理
    if (res.status === OK && res.data.status === OK) {
      const resData = res.data.data[0]
      context.commit('setNewLocation', resData)
    }

    // レスポンスが空の処理
    if (res.status === OK && res.data.status === NO_RECORD) {
      const errors = res.data.errors.message
      context.commit('setErrorMessages', errors)
    }
  },
  async setSetting(context, distance) {
    context.commit('setSetting', distance)
  }
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}