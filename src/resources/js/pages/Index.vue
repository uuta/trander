<template>
  <div class="container">
    <div id="map">
      <Setting></Setting>
      <GmapMap :center="{lat:seeLat, lng:seeLng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLat, lng:currentLng}" :icon="icon_center">
        </gmap-marker>
        <gmap-marker v-if="icon" :position="{lat:lat, lng:lng}">
        </gmap-marker>
      </GmapMap>
      <div id="map_info">
        <div>
          現在地：東京都中央区
          <div v-if="cityName">
            {{ cityName }}
          </div>
          <div v-if="errorMessages">
            {{ errorMessages }}
          </div>
        </div>
        <button @click="setNewLocation" class="button_map button_map_info"><i class="fas fa-plus"></i></button>
      </div>
      <button class="button_map_setting"><i class="fas fa-cog" @click.self="showSettingModal"></i></button>
      <div id="map_overlay" v-if="modal" @click.self="hiddenModal">
        <div id="map_overlay_wrap">
          <p><i class="fas fa-crown"></i> おめでとうございます！新しいロケーションを発見しました。</p>
          <p v-if="cityName">
            {{ cityName }}
          </p>
          <p> 早速、冒険に出てみましょう！</p>
          <div v-if="lat">
            {{ lat }}
          </div>
          <div v-if="lng">
            {{ lng }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Setting from './Setting.vue'

export default {
  components: {
    Setting
  },
  data () {
    return {
      icon_center: {
        url: '/assets/images/current_location.png',
        scaledSize: {width: 30, height: 30, f: 'px', b: 'px'}
      }
    }
  },
  created:function(){
    this.getCurrentLocation() // DOMの読み込み前に現在地を取得
  },
  computed: mapState({
    cityName: state => state.external.cityName,
    lat: state => state.external.lat,
    lng: state => state.external.lng,
    currentLat: state => state.external.currentLat,
    currentLng: state => state.external.currentLng,
    seeLat: state => state.external.seeLat,
    seeLng: state => state.external.seeLng,
    icon: state => state.external.icon,
    modal: state => state.external.modal,
    distance: state => state.external.distance,
    settingModal: state => state.external.settingModal,
    errorMessages: state => state.external.errorMessages
  }),
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
    setNewLocation() {
      const data = {
        lat: this.currentLat,
        lng: this.currentLng,
        min: this.distance[0] * 1000,
        max: this.distance[1] * 1000
      }
      const router = this.$router
      this.$store.dispatch('external/setNewLocation', {data, router})
    },
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    },
    showSettingModal() {
      this.$store.commit('external/setSettingModal', true)
    },
  }
}
</script>