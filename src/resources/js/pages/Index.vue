<template>
  <div class="container--small">
    <div id="map">
      <GmapMap :center="{lat:seeLocation.lat, lng:seeLocation.lng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLocation.lat, lng:currentLocation.lng}" :icon="icon_center">
        </gmap-marker>
        <gmap-marker v-if="showIcon" :position="{lat:suggestLocation.lat, lng:suggestLocation.lng}">
        </gmap-marker>
      </GmapMap>
      <div id="map_info">
        <div>
          現在地：北海道札幌市中央区
        </div>
      </div>
      <div id="map_btn">
        <button v-on:click="setNewLocation" class="button_map"><i class="fas fa-user-cog"></i></button>
        <button v-on:click="setNewLocation" class="button_map"><i class="fas fa-plus"></i></button>
      </div>
      <div id="map_overlay" v-if="showModal" v-on:click="hiddenModal">
        <div id="map_overlay_wrap">
          <p><i class="fas fa-crown"></i> おめでとうございます！新しいロケーションを発見しました。</p>
          <p> 北海道札幌市西区</p>
          <p> 早速、冒険に出てみましょう！</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      seeLocation: { lat: 0, lng: 0},
      currentLocation : { lat : 0, lng : 0},
      suggestLocation : { lat : 0, lng : 0},
      searchAddressInput: '',
      icon_center: {
        url: '/assets/images/current_location.png',
        scaledSize: {width: 30, height: 30, f: 'px', b: 'px'}
      },
      showIcon: false,
      showModal: false
    }
  },
  created:function(){
    this.getCurrentLocation() // DOMの読み込み前に現在地を取得
  },
  methods: {
     getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        const latAndLong = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.seeLocation = latAndLong
        this.currentLocation = latAndLong
      });
    },
    setNewLocation() {
      const latAndLong = {
        lat: 43.067883,
        lng: 141.322995
      }
      this.displayedIcon()
      this.displayedModal()
      this.suggestLocation = latAndLong
      this.seeLocation = latAndLong
    },
    displayedIcon() {
      this.showIcon = true
    },
    displayedModal() {
      this.showModal = true
    },
    hiddenModal() {
      this.showModal = false
    },
  }
}
</script>