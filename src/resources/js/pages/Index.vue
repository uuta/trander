<template>
    <div id="map">
        <GmapMap :center="{lat:currentLocation.lat, lng:currentLocation.lng}" :zoom="14" :options="{disableDefaultUI:true}" style="width: 100%; height: 100%;">
      </GmapMap>
    </div>
</template>

<script>
export default {
  data () {
    return {
      currentLocation : { lat : 0, lng : 0},
      searchAddressInput: ''
    }
  },
  created:function(){
    this.getCurrentLocation() // DOMの読み込み前に現在地を取得
  },
  methods: {
     getCurrentLocation() {
      console.log('1階層目')
      navigator.geolocation.getCurrentPosition((position) => {
        console.log('2階層目')
        this.currentLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        console.log('this.currentLocationは', this.currentLocation)
      }, (failure) => {console.log('失敗')});
    }
  }
}
</script>