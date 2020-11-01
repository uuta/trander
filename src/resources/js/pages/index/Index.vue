<template>
  <div class="container p-city_detail">
    <vue-progress-bar></vue-progress-bar>
    <Bars v-show="loading"></Bars>
    <div id="map" v-bind:class="{show_city_detail: isShowCityDetail}">
      <Registration v-if="registerModal"></Registration>
      <Error></Error>
      <SuggestCurrentLocation v-if="geoLocationModal"></SuggestCurrentLocation>
      <Setting></Setting>
      <GmapMap :center="{lat:seeLat, lng:seeLng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLat, lng:currentLng}" :icon="icon_center">
        </gmap-marker>
        <gmap-marker v-if="icon" :position="{lat:lat, lng:lng}">
        </gmap-marker>
      </GmapMap>
      <KwModal v-if="kwModal"></KwModal>
      <MapInfo></MapInfo>
      <button class="button_map_setting"><i class="fas fa-cog" @click.self="showSettingModal"></i></button>
      <Searched></Searched>
    </div>
    <CityDetail></CityDetail>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Setting from './Modal/Setting.vue'
import CityDetail from '../cityDetails/index.vue'
import MapInfo from '../../components/organisms/index/mapInfo.vue'
import KwModal from '../../components/organisms/kw/Modal.vue'
import Registration from './Modal/Registration.vue'
import Searched from './Modal/Searched.vue'
import SuggestCurrentLocation from './Modal/Suggest/CurrentLocation.vue'
import Error from '../../components/organisms/errors/Modal.vue'
import Bars from '../../components/atoms/loader/Bars.vue'
import CONST_EXTERNAL from '../../const/external.js'
import { BROWSER, URL_TYPE } from '../../const/common.js'
import { checkBrowser } from '../../services/common/checkBrowser.js'

export default {
  components: {
    Setting,
    CityDetail,
    MapInfo,
    KwModal,
    Registration,
    Searched,
    SuggestCurrentLocation,
    Error,
    Bars,
  },
  data() {
    return {
      icon_center: {
        url: '/assets/images/current_location.png',
        scaledSize: {width: 30, height: 30, f: 'px', b: 'px'}
      },
    }
  },
  created() {
    this.SUGGEST = CONST_EXTERNAL.CURRENT_LOCATION_SUGGEST
    this.checkRegistration()
    this.judgeGeoLocation()
    this.setSearchingUrl()
    this.$store.commit('external/setSettingModal', false)
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      currentLat: state => state.external.currentLat,
      currentLng: state => state.external.currentLng,
      seeLat: state => state.external.seeLat,
      seeLng: state => state.external.seeLng,
      icon: state => state.external.icon,
      wikiDataId: state => state.external.wikiDataId,
      settingModal: state => state.external.settingModal,
      errorMessages: state => state.external.errorMessages,
      geoLocationModal: state => state.external.geoLocationModal,
      registerModal: state => state.auth.registerModal,
      loading: state => state.auth.loading,
      kwModal: state => state.kw.modal,
    }),
    isShowCityDetail() {
      return Boolean(Object.keys(this.$route.params).length)
    },
  },
  methods: {
    judgeGeoLocation() {
      // In case, browser doesn't support
      if (!navigator.geolocation) {
        this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.BROWSER)
      }

      // Check a browser name
      const browser = checkBrowser();

      // Permission of current location setting
      if (browser === BROWSER.EDGE || browser === BROWSER.CHROME || browser === BROWSER.FIREFOX || browser === BROWSER.OPERA) {
        navigator.permissions.query({name: 'geolocation'}).then(result => {
          if(result.state === 'granted') {
            this.getCurrentLocation()
          }
          if(result.state === 'prompt') {
            this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.SUGGEST)
            this.getCurrentLocation()
          }
          if(result.state === 'denied') {
            this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.PERMISSION)
          }
          result.onchange = function() {
            if(result.state === 'granted') {
              this.getCurrentLocation()
            }
            if(result.state === 'denied') {
              this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.PERMISSION)
            }
          }
        })
      } else {
        this.getCurrentLocation()
      }
    },
    getCurrentLocation() {
      const options = {
        enableHighAccuracy: false,
        timeout: 10000,
        maximumAge: 0,
      }

      navigator.geolocation.getCurrentPosition(this.successGetCurrentPosition, this.errorGetCurrentPosition, options)
    },
    async successGetCurrentPosition(position) {
      const data = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      }
      await this.$store.dispatch('external/getLoading', data)

      if (Boolean(Object.keys(this.$route.params).length)) {
        const cityId = {
          params: {
            id: Number(this.$route.params.cityId),
          }
        }
        await this.$store.dispatch('external/getCityById', cityId)

        const distanceLatLng = {
          params: {
            lat: this.currentLat,
            lng: this.currentLng,
            cityLat: this.lat,
            cityLng: this.lng,
          }
        }
        const latLng = {
          params: {
            lat: this.lat,
            lng: this.lng,
          }
        }
        const wiki = {
          params: {
            wikiId: this.wikiDataId,
          }
        }
        this.$store.dispatch('external/getDistance', distanceLatLng)
        this.$store.dispatch('external/getHotel', latLng)
        this.$store.dispatch('external/getFacility', latLng)
        this.$store.dispatch('external/getWeather', latLng)
        this.$store.dispatch('external/getWiki', wiki)
      }
    },
    errorGetCurrentPosition(error) {
      // Show an error modal
      switch (error.code) {
        case 1: // Permission denied
          this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.PERMISSION)
          break
        case 2: // Position unavailable
          this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.UNAVAILABLE)
          break
        case 3: // Timeout
          this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.TIMEOUT)
          break
        default:
          this.$store.commit('external/setGeoLocationSetting', this.SUGGEST.UNAVAILABLE)
          break
      }
    },
    checkRegistration() {
      this.$store.dispatch('auth/checkRegistration')
    },
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    },
    showSettingModal() {
      this.$store.commit('external/setSettingModal', true)
    },
    setSearchingUrl() {
      const url = this.$route.path.indexOf('index') != -1
        ? URL_TYPE.CITY
        : URL_TYPE.KW
      this.$store.commit('external/setSearchingUrl', url)
    },
  }
}
</script>