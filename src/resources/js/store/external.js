import {
  OK,
  NO_RECORD,
} from '../util'

const state = {
  cityName: null,
  region: null,
  countryCode: null,
  lat: null,
  lng: null,
  currentLat: null,
  currentLng: null,
  seeLat: null,
  seeLng: null,
  icon: false,
  modal: false,
  settingModal: false,
  rangeOfDistance: [0, 100],
  msg: '車や電車で遠出しましょう',
  errorMessages: null,
  suggestPushing: false,
  distance: null,
  direction: null,
  walking: null,
  bycicle: null,
  car: null,
  geoLocationModal: false,
  geoLocationSetting: null
}

const getters = {}

const mutations = {
  setNewLocation(state, value) {
    state.cityName = value.city
    state.region = value.region
    state.countryCode = value.countryCode
    state.lat = value.latitude
    state.lng = value.longitude
    state.seeLat = value.latitude
    state.seeLng = value.longitude
    state.icon = true
    state.modal = true
    setTimeout(() => state.suggestPushing = true, 5000)
    state.distance = value.distance
    state.direction = value.direction
    state.walking = value.ways.walking
    state.bycicle = value.ways.bycicle
    state.car = value.ways.car
  },
  setModal(state, value) {
    state.modal = value
  },
  setSettingModal(state, value) {
    state.settingModal = value
  },
  setRangeOfDistance(state, value) {
    state.rangeOfDistance = value
  },
  setMsg(state, value) {
    state.msg = value
  },
  setCurrentLocation(state, value) {
    state.currentLat = value.lat
    state.currentLng = value.lng
    state.seeLat = value.lat
    state.seeLng = value.lng
  },
  setSetting(state, value) {
    state.rangeOfDistance = value
    state.settingModal = false
  },
  setErrorMessages(state, value) {
    state.errorMessages = value
  },
  setSuggestPushing(state, value) {
    state.suggestPushing = value
  },
  setGeoLocationModal(state, value) {
    state.geoLocationModal = value
  },
  setGeoLocationSetting(state, value) {
    state.geoLocationModal = true
    state.geoLocationSetting = value
  },
}

const actions = {
  async getLoading(context, data) {
    const res = await axios.get('/api/setting')

    // レスポンスが空ではない時の処理
    if (res.status === OK && Object.keys(res.data).length) {
      const rangeOfDistance = [
        res.data.min_distance, res.data.max_distance
      ]
      context.commit('setRangeOfDistance', rangeOfDistance)
    }

    // レスポンスが空の処理
    if (res.status === OK && !Object.keys(res.data).length) {
      ;
    }

    // 現在地をセット
    context.commit('setCurrentLocation', data)
    // 現在地権限モーダルの削除
    context.commit('setGeoLocationModal', false)
  },
  async setNewLocation(context, { data, router }) {
    context.commit('setSuggestPushing', false)
    const res = await axios.post('/api/external/geo-db-cities', data)

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
  async setSetting(context, { rangeOfDistance, setting }) {
    context.commit('setSetting', rangeOfDistance)
    await axios.post('/api/setting', setting)
  }
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}