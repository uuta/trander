import {
  OK,
  NO_RECORD,
  UNPROCESSABLE_ENTITY,
} from '../util'

const state = {
  keyword: '',
  name: null,
  icon: null,
  rating: null,
  photo: null,
  vicinity: null,
  userRatingsTotal: null,
  priceLevel: null,
  lat: null,
  lng: null,
  placeId: null,
  modal: false,
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
}

const actions = {
  // Get nearBySearch
  async getNearBySearch(context, params) {
    console.log(params)
    const res = await axios.get('/api/external/near-by-search', params)
    const resData = res.data
    console.log(resData)

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
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}