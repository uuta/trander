<template>
  <div class="container--small">
    <div id="map">
      <GmapMap :center="{lat:currentLocation.lat, lng:currentLocation.lng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLocation.lat, lng:currentLocation.lng}" :icon="icon_center">
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
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      currentLocation : { lat : 0, lng : 0},
      searchAddressInput: '',
      icon_center: {
        url: '/assets/images/current_location.png',
        scaledSize: {width: 30, height: 30, f: 'px', b: 'px'}
      },
    }
  },
  created:function(){
    this.getCurrentLocation() // DOMの読み込み前に現在地を取得
  },
  methods: {
     getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.currentLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    },
    setNewLocation() {
      this.currentLocation = {
        lat: 43.067883,
        lng: 141.322995
      }
    }
  }
}
</script>