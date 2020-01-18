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
  errorMessages: null
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
  setErrorMessages(state, errorMessages) {
    state.errorMessages = errorMessages
  },
}

const actions = {
  async setNewLocation(context, { latLng, router }) {
    const responseDatas = await axios.post('/api/external/geo-db-cities', latLng)

    if (responseDatas.status === OK && responseDatas.data.status === OK) {
      const responseData = responseDatas.data.data[0]
      const city = responseData.city
      const lat = responseData.latitude
      const lng = responseData.longitude

      context.commit('setcityName', city)
      context.commit('setLat', lat)
      context.commit('setLng', lng)
      context.commit('setSeeLat', lat)
      context.commit('setSeeLng', lng)
      context.commit('setIcon', true)
      context.commit('setModal', true)
    }

    if (responseDatas.status === OK && responseDatas.data.status === NO_RECORD) {
      const errors = responseDatas.data.errors.message
      context.commit('setErrorMessages', errors)
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