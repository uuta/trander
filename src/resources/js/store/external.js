import {
  OK,
  NO_RECORD,
  UNPROCESSABLE_ENTITY,
} from '../util'

import {
  DIRECTION_TYPE
} from '../const/external'

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
  geoLocationSetting: null,
  directionType: DIRECTION_TYPE.NONE.NUM,
  settingDirection: false,
  hotels: null,
  hotelsShowing: false,
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
    state.rangeOfDistance = value.distance
    state.directionType = value.directionType
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
  setSettingDirection(state, value) {
    state.settingDirection = value
  },
  setDirectionType(state, value) {
    state.directionType = value
    state.settingDirection = false
  },
  setHotel(state, value) {
    state.hotels = value
    state.hotelsShowing = true
  },
}

const actions = {
  async getLoading(context, data) {
    const res = await axios.get('/api/setting')

    // レスポンスが空ではない時の処理
    if (res.status === OK && Object.keys(res.data).length) {
      const settings = {
        distance: [
          res.data.min_distance,
          res.data.max_distance
        ],
        directionType: res.data.direction_type,
      }
      context.commit('setSetting', settings)
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
  async setSetting(context, { states, parameters }) {
    context.commit('setSetting', states)
    context.commit('setSettingModal', false)
    await axios.post('/api/setting', parameters)
  },
  async setDirectionType(context, data) {
    context.commit('setDirectionType', data)
  },
  // Hotel
  async getHotel(context, params) {
    const res = await axios.get('/api/external/hotel', params)
    const resData = res.data

    if (res.status === OK) {
      context.commit('setHotel', resData)
    }

    if (res.status === UNPROCESSABLE_ENTITY) {
      const resErrors = res.data.errors
      context.commit('setErrorMessages', resErrors)
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