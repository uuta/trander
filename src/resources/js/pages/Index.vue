<template>
  <div class="container--small">
    <div id="map">
      <GmapMap :center="{lat:setSeeLat, lng:setSeeLng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:setCurrentLat, lng:setCurrentLng}" :icon="icon_center">
        </gmap-marker>
        <gmap-marker v-if="icon" :position="{lat:setLat, lng:setLng}">
        </gmap-marker>
      </GmapMap>
      <div id="map_info">
        <div>
          現在地：東京都中央区
          <div v-if="setCityName">
            {{ setCityName }}
          </div>
          <div v-if="errorMessages">
            {{ errorMessages }}
          </div>
        </div>
      </div>
      <div id="map_btn">
        <button @click="setNewLocation" class="button_map"><i class="fas fa-user-cog"></i></button>
        <button @click="setNewLocation" class="button_map"><i class="fas fa-plus"></i></button>
      </div>
      <div id="map_overlay" v-if="modal" @click.self="hiddenModal">
        <div id="map_overlay_wrap">
          <p><i class="fas fa-crown"></i> おめでとうございます！新しいロケーションを発見しました。</p>
          <p v-if="setCityName">
            {{ setCityName }}
          </p>
          <p> 早速、冒険に出てみましょう！</p>
          <div v-if="setLat">
            {{ setLat }}
          </div>
          <div v-if="setLng">
            {{ setLng }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data () {
    return {
      searchAddressInput: '',
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
    setCityName: state => state.external.cityName,
    setLat: state => state.external.lat,
    setLng: state => state.external.lng,
    setCurrentLat: state => state.external.currentLat,
    setCurrentLng: state => state.external.currentLng,
    setSeeLat: state => state.external.seeLat,
    setSeeLng: state => state.external.seeLng,
    icon: state => state.external.icon,
    modal: state => state.external.modal,
    errorMessages: state => state.external.errorMessages
  }),
  methods: {
     getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        const latLng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.$store.commit('external/setSeeLat', latLng.lat)
        this.$store.commit('external/setSeeLng', latLng.lng)
        this.$store.commit('external/setCurrentLat', latLng.lat)
        this.$store.commit('external/setCurrentLng', latLng.lng)
      });
    },
    setNewLocation() {
      const latLng = {
        lat: this.setCurrentLat,
        lng: this.setCurrentLng
      }
      this.$store.dispatch('external/setNewLocation', latLng)
    },
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    },
  }
}
</script>