import {
  OK,
  NO_RECORD,
  UNPROCESSABLE_ENTITY,
} from '../util'

const state = {
  keyword: '',
  successful: false,
  name: null,
  icon: null,
  rating: null,
  photo: null,
  vicinity: null,
  userRatingsTotal: null,
  priceLevel: null,
  ratingStar: null,
  lat: null,
  lng: null,
  placeId: null,
  modal: false,
  distance: null,
  direction: null,
  walking: null,
  bycicle: null,
  car: null,
  errorMessages: null,
  errorModal: false,
}

const getters = {}

const mutations = {
  setErrorMessages(state, value) {
    state.errorMessages = value
    state.errorModal = true
  },
  setNearBySearch(state, value) {
    state.successful = true
    state.name = value.name
    state.icon = value.icon
    state.rating = value.rating
    state.photo = value.photo
    state.vicinity = value.vicinity
    state.userRatingsTotal = value.userRatingsTotal
    state.priceLevel = value.priceLevel
    state.ratingStar = value.ratingStar
    state.lat = value.lat
    state.lng = value.lng
    state.placeId = value.placeId
    state.errorMessages = null
    state.modal = true
  },
  setKeyword(state, value) {
    state.keyword = value
  },
  setModal(state, value) {
    state.modal = value
  },
  undoErrorMessages(state) {
    state.errorMessages = null
  },
  setDistance(state, value) {
    state.distance = value.distance
    state.direction = value.direction
    state.walking = value.ways.walking
    state.bycicle = value.ways.bycicle
    state.car = value.ways.car
  },
  setGooglePlace(state, value) {
    state.successful = true
    state.name = value.name
    state.icon = value.icon
    state.rating = value.rating
    state.photo = value.photo
    state.vicinity = value.vicinity
    state.userRatingsTotal = value.userRatingsTotal
    state.priceLevel = value.priceLevel
    state.lat = value.lat
    state.lng = value.lng
    state.placeId = value.placeId
    state.ratingStar = value.ratingStar
  },
}

const actions = {
  // Get nearBySearch
  async getNearBySearch(context, params) {
    const res = await axios.get('/api/external/near-by-search', params)
    const resData = res.data

    if (res.status === OK) {
      context.commit('setNearBySearch', resData)
    }

    if (res.status === NO_RECORD) {
      context.commit('undoErrorMessages')
    }

    if (res.status === UNPROCESSABLE_ENTITY) {
      const resErrors = res.data.errors
      context.commit('setErrorMessages', resErrors)
    }
  },
  // Get distance
  async getDistance(context, params) {
    const res = await axios.get('/api/distance', params)
    const resData = res.data

    if (res.status === OK) {
      context.commit('setDistance', resData)
    }

    if (res.status === NO_RECORD) {
      return false;
    }

    if (res.status === UNPROCESSABLE_ENTITY) {
      const resErrors = res.data.errors
      context.commit('setErrorMessages', resErrors)
    }
  },
  // Get google place
  async getGooglePlace(context, params) {
    const res = await axios.get('/api/google-place', params)
    const resData = res.data

    if (res.status === OK) {
      context.commit('setGooglePlace', resData)
    }

    if (res.status === NO_RECORD) {
      return false;
    }

    if (res.status === UNPROCESSABLE_ENTITY) {
      const resErrors = res.data.errors
      context.commit('setErrorMessages', resErrors)
    }
  },
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}