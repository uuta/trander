<template>
  <div id="map_info">
    <SearchList></SearchList>
    <div class="map_info_desc">
      <MapInfoItem v-if="cityName"></MapInfoItem>
      <MapInfoIntroduction v-else></MapInfoIntroduction>
      <transition name="fade">
        <SuggestPushing v-show="suggestPushing"></SuggestPushing>
      </transition>
    </div>
    <button @click="setNewLocation" class="button_map button_map_info"><i class="fas fa-plus"></i></button>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import SuggestPushing from '../../../pages/index/Modal/Suggest/Pushing.vue'
import MapInfoItem from '../../molecules/mapInfo/Item.vue'
import MapInfoIntroduction from '../../molecules/mapInfo/Introduction.vue'
import SearchList from '../../molecules/tab/SearchList.vue'

export default {
  components: {
    SuggestPushing,
    MapInfoItem,
    MapInfoIntroduction,
    SearchList,
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      currentLat: state => state.external.currentLat,
      currentLng: state => state.external.currentLng,
      rangeOfDistance: state => state.external.rangeOfDistance,
      cityName: state => state.external.cityName,
      suggestPushing: state => state.external.suggestPushing,
      directionType: state => state.external.directionType,
      wikiDataId: state => state.external.wikiDataId,
    }),
  },
  methods: {
    setNewLocation() {
      const data = {
        lat: this.currentLat,
        lng: this.currentLng,
        min: this.rangeOfDistance[0],
        max: this.rangeOfDistance[1],
        direction_type: this.directionType,
      }
      const router = this.$router
      this.showProgressBar(data, router)
    },
    async showProgressBar(data, router) {
      this.$Progress.start()
      await this.$store.dispatch('external/setNewLocation', {data, router})
      this.setCityDetail()
      this.$Progress.finish()
    },
    setCityDetail() {
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
      this.$store.dispatch('external/getHotel', latLng)
      this.$store.dispatch('external/getFacility', latLng)
      this.$store.dispatch('external/getWeather', latLng)
      this.$store.dispatch('external/getWiki', wiki)
    },
  },
}
</script>