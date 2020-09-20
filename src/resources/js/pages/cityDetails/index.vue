<template>
  <div class="p-city_detail_wrap" v-if="isShowCityDetail">
    <RouterLink class="negate_btn back_to_index" :to="{name: 'index'}">
      <button class="item_btn"><i class="fas fa-angle-right"></i></button>
    </RouterLink>
    <div class="heading">
      <picture class="thumbnail">
        <img class="image" :src="headerImage">
        <h2 class="caption">
          <img class="flag" :src="setCountryImg">
          <span class="desc">{{region + " " + cityName }}</span>
        </h2>
      </picture>
    </div>
    <div class="content_container">
      <Wiki></Wiki>
      <Hotel></Hotel>
      <Facility></Facility>
      <Weather></Weather>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Wiki from '../../components/organisms/cityDetails/Wiki'
import Hotel from '../../components/organisms/cityDetails/Hotel'
import Facility from '../../components/organisms/cityDetails/Facility'
import Weather from '../../components/organisms/cityDetails/Weather'

export default {
  components: {
    Wiki,
    Hotel,
    Facility,
    Weather,
  },
  computed: {
    ...mapState({
      cityName: state => state.external.cityName,
      region: state => state.external.region,
      countryCode: state => state.external.countryCode,
    }),
    setCountryImg() {
      if (this.countryCode != null) {
        return 'https://www.countryflags.io/' + this.countryCode + '/flat/32.png'
      }
    },
    isShowCityDetail() {
      return Boolean(Object.keys(this.$route.params).length)
    },
    headerImage() {
      return 'https://source.unsplash.com/featured/?'
        + this.region + '-'
        + this.cityName
    },
  },
}
</script>