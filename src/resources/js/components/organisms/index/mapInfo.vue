<template>
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
        <RouterLink v-if="showAngleBtn" class="negate_btn show_detail" :to="{name: 'cityDetail', params: {cityId: cityId}}">
          <button class="item_btn"><i class="fas fa-angle-up"></i></button>
        </RouterLink>
        <RouterLink v-else class="negate_btn show_detail" :to="{name: 'index'}">
          <button class="item_btn"><i class="fas fa-angle-right"></i></button>
        </RouterLink>
      </dl>
      <dl class="map_info_introduction" v-else>
        <dt class="title"><i class="fas fa-street-view"></i>新しい街に行ってみよう</dt>
        <dd class="list">
          {{ username }}さん、こんにちは！<br>
          ボタンを押して、近くの街を探してみましょう。
        </dd>
      </dl>
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
import CONST_EXTERNAL from '../../../const/external.js'

export default {
  components: {
    SuggestPushing,
  },
  created() {
    this.RECOMMEND_FREQUENCY = CONST_EXTERNAL.RECOMMEND_FREQUENCY
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      countryCode: state => state.external.countryCode,
      currentLat: state => state.external.currentLat,
      currentLng: state => state.external.currentLng,
      rangeOfDistance: state => state.external.rangeOfDistance,
      cityName: state => state.external.cityName,
      region: state => state.external.region,
      suggestPushing: state => state.external.suggestPushing,
      distance: state => state.external.distance,
      direction: state => state.external.direction,
      directionType: state => state.external.directionType,
      walking: state => state.external.walking,
      bycicle: state => state.external.bycicle,
      car: state => state.external.car,
      wikiDataId: state => state.external.wikiDataId,
      cityId: state => state.external.cityId,
    }),
    ...mapGetters({
      username: 'auth/username'
    }),
    setCountryImg: function() {
      if (this.countryCode != null) {
        return 'https://www.countryflags.io/' + this.countryCode + '/flat/32.png'
      }
    },
    showAngleBtn: function() {
      return !Object.keys(this.$route.params).length
    },
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