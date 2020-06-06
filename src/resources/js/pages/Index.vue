<template>
  <div class="container">
    <vue-progress-bar></vue-progress-bar>
    <Bars v-show="loading"></Bars>
    <div id="map">
      <Registration></Registration>
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
            <dt><i class="fas fa-crown"></i>街を見つけました！</dt>
            <dd>
              <img :src="setCountryImg" class="country_flag">
              <span class="desc">{{region + " " + cityName }}</span>
            </dd>
          </dl>
          <p v-else>
            {{ username }}さん、こんにちは！<br>
            ボタンを押して、近くの街を探してみましょう。
          </p>
          <p v-if="errorMessages">
            {{ errorMessages }}
          </p>
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
import Setting from './Setting.vue'
import Registration from '../components/modal/Registration.vue'
import Searched from '../components/modal/Searched.vue'
import Bars from '../components/loader/Bars.vue'

export default {
  components: {
    Setting,
    Registration,
    Searched,
    Bars
  },
  data () {
    return {
      icon_center: {
        url: '/assets/images/current_location.png',
        scaledSize: {width: 30, height: 30, f: 'px', b: 'px'}
      },
    }
  },
  created:function(){
    this.getCurrentLocation() // DOMの読み込み前に現在地を取得
    this.checkRegistration()
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
      distance: state => state.external.distance,
      settingModal: state => state.external.settingModal,
      errorMessages: state => state.external.errorMessages,
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
     getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        const data = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.$store.dispatch('external/getLoading', data)
      });
    },
    checkRegistration() {
      this.$store.dispatch('auth/checkRegistration')
    },
    setNewLocation() {
      const data = {
        lat: this.currentLat,
        lng: this.currentLng,
        min: this.distance[0] * 1000,
        max: this.distance[1] * 1000
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