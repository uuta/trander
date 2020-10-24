<template>
  <div id="map_info">
    <SearchList></SearchList>
    <div class="map_info_desc">
      <template v-if="this.searchingUrl === this.URL_TYPE.CITY">
        <CityItem v-if="cityName"></CityItem>
        <CityIntroduction v-else></CityIntroduction>
      </template>
      <template v-if="this.searchingUrl === this.URL_TYPE.KW">
        <KwIntroduction></KwIntroduction>
      </template>
      <transition name="fade">
        <SuggestPushing v-show="suggestPushing"></SuggestPushing>
      </transition>
    </div>
    <button @click="setNewLocation" class="button_map button_map_info"><i class="fas fa-plus"></i></button>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import { URL_TYPE } from '../../../const/common.js'
import SuggestPushing from '../../../pages/index/Modal/Suggest/Pushing.vue'
import CityItem from '../../molecules/mapInfo/city/Item.vue'
import CityIntroduction from '../../molecules/mapInfo/city/Introduction.vue'
import KwIntroduction from '../../molecules/mapInfo/kw/Introduction.vue'
import SearchList from '../../molecules/tab/SearchList.vue'

export default {
  data() {
    return {
      URL_TYPE,
    }
  },
  components: {
    SuggestPushing,
    CityItem,
    CityIntroduction,
    KwIntroduction,
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
      searchingUrl: state => state.external.searchingUrl,
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