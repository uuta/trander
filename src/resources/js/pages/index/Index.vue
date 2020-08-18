<template>
  <div class="container">
    <vue-progress-bar></vue-progress-bar>
    <Bars v-show="loading"></Bars>
    <div id="map">
      <Registration v-if="registerModal"></Registration>
      <SuggestCurrentLocation v-if="geoLocationModal"></SuggestCurrentLocation>
      <Setting></Setting>
      <GmapMap :center="{lat:seeLat, lng:seeLng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLat, lng:currentLng}" :icon="icon_center">
        </gmap-marker>
        <gmap-marker v-if="icon" :position="{lat:lat, lng:lng}">
        </gmap-marker>
      </GmapMap>
      <div id="map_info">
        <div class="map_info_desc">
          <dl v-if="cityName" class="map_info_items">
            <dt class="title"><i class="fas fa-smile"></i>荷物をまとめて出かけよう！</dt>
            <dd class="list">
              <img :src="setCountryImg" class="country_flag">
              <span class="desc">{{region + " " + cityName }}</span>
            </dd>
            <dd class="list info">距離：{{distance}} km</dd>
            <dd class="list info">方角：{{direction}}</dd>
            <dd class="list">
              <ul class="flex items">
                <li class="item"><i class="fas fa-walking" :class="[
                  walking === RECOMMEND_FREQUENCY.NONE ? 'none'
                  : walking === RECOMMEND_FREQUENCY.MIDDLE ? 'middle'
                  : 'high'
                ]"></i></li>
                <li class="item"><i class="fas fa-biking" :class="[
                  bycicle === RECOMMEND_FREQUENCY.NONE ? 'none'
                  : bycicle === RECOMMEND_FREQUENCY.MIDDLE ? 'middle'
                  : 'high'
                ]"></i></li>
                <li class="item"><i class="fas fa-car" :class="[
                  car === RECOMMEND_FREQUENCY.NONE ? 'none'
                  : car === RECOMMEND_FREQUENCY.MIDDLE ? 'middle'
                  : 'high'
                ]"></i></li>
              </ul>
            </dd>
          </dl>
          <dl class="map_info_introduction" v-else>
            <dt class="title"><i class="fas fa-street-view"></i>さぁ、冒険の世界へ...</dt>
            <dd class="list">
              {{ username }}さん、こんにちは！<br>
              ボタンを押して、近くの街を探してみましょう。
            </dd>
          </dl>
          <p v-if="errorMessages">
            {{ errorMessages }}
          </p>
          <transition name="fade">
            <SuggestPushing v-show="suggestPushing"></SuggestPushing>
          </transition>
        </div>
        <button @click="setNewLocation" class="button_map button_map_info"><i class="fas fa-plus"></i></button>
      </div>
      <button class="button_map_setting"><i class="fas fa-cog" @click.self="showSettingModal"></i></button>
      <Searched></Searched>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Setting from './Modal/Setting.vue'
import Registration from './Modal/Registration.vue'
import Searched from './Modal/Searched.vue'
import SuggestPushing from './Modal/Suggest/Pushing.vue'
import SuggestCurrentLocation from './Modal/Suggest/CurrentLocation.vue'
import Bars from '../../components/loader/Bars.vue'
import CONST_EXTERNAL from '../../const/external.js'
import { BROWSER } from '../../const/common.js'
import { checkBrowser } from '../../extension/checkBrowser.js'

export default {
  components: {
    Setting,
    Registration,
    Searched,
    SuggestPushing,
    SuggestCurrentLocation,
    Bars
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
    this.RECOMMEND_FREQUENCY = CONST_EXTERNAL.RECOMMEND_FREQUENCY
    this.SUGGEST = CONST_EXTERNAL.CURRENT_LOCATION_SUGGEST
    this.checkRegistration()
    this.judgeGeoLocation()
    this.$store.commit('external/setSettingModal', false)
  },
  computed: {
    ...mapState({
      cityName: state => state.external.cityName,
      region: state => state.external.region,
      countryCode: state => state.external.countryCode,
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      currentLat: state => state.external.currentLat,
      currentLng: state => state.external.currentLng,
      seeLat: state => state.external.seeLat,
      seeLng: state => state.external.seeLng,
      icon: state => state.external.icon,
      rangeOfDistance: state => state.external.rangeOfDistance,
      settingModal: state => state.external.settingModal,
      errorMessages: state => state.external.errorMessages,
      suggestPushing: state => state.external.suggestPushing,
      direction: state => state.external.direction,
      distance: state => state.external.distance,
      walking: state => state.external.walking,
      bycicle: state => state.external.bycicle,
      car: state => state.external.car,
      geoLocationModal: state => state.external.geoLocationModal,
      directionType: state => state.external.directionType,
      registerModal: state => state.auth.registerModal,
      loading: state => state.auth.loading
    }),
    ...mapGetters({
      username: 'auth/username'
    }),
    setCountryImg: function() {
      if (this.countryCode != null) {
        return 'https://www.countryflags.io/' + this.countryCode + '/flat/32.png'
      }
    }
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
    successGetCurrentPosition(position) {
      const data = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      }
      this.$store.dispatch('external/getLoading', data)
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
    setNewLocation() {
      const data = {
        lat: this.currentLat,
        lng: this.currentLng,
        min: this.rangeOfDistance[0] * 1000,
        max: this.rangeOfDistance[1] * 1000,
        direction_type: this.directionType,
      }
      const router = this.$router
      this.showProgressBar(data, router)
    },
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    },
    showSettingModal() {
      this.$store.commit('external/setSettingModal', true)
    },
    async showProgressBar(data, router) {
      this.$Progress.start()
      await this.$store.dispatch('external/setNewLocation', {data, router})
      this.$Progress.finish()
    },
  }
}
</script>