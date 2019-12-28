<template>
    <div id="map">
        <GmapMap :center="{lat:currentLocation.lat, lng:currentLocation.lng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
        <gmap-marker :position="{lat:currentLocation.lat, lng:currentLocation.lng}" :icon="icon_center">
      </gmap-marker>
      </GmapMap>
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
    }
  }
}
</script>