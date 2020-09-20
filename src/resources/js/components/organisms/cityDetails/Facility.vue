<template>
  <div class="contents_wrap">
    <h3 class="title" @click="getFacility">周辺施設</h3>
    <div class="slider_wrap">
      <div class="content facility" v-for="facility in facilities">
        <picture class="thumbnail position_parent">
          <img class="image" :src="getFacilityImg(facility)" @error="showDefImg">
          <p class="title position_child">{{facility.name}}</p>
        </picture>
        <dl class="info">
          <dd class="genre">{{facility.genre}}</dd>
          <dd class="rating">{{facility.rating}}</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  data() {
    return {
      thumbnail: 'https://source.unsplash.com/featured/?tokyo',
      defImg: '/assets/images/facilities/general.png',
      hotel: '/assets/images/hotels/hotel.png',
      noodle: '/assets/images/facilities/noodle.png',
      flower: '/assets/images/facilities/flower.png',
      administration: '/assets/images/facilities/administration.png',
      beautySalon: '/assets/images/facilities/beauty_salon.png',
      shrine: '/assets/images/facilities/shrine.png',
    }
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      facilities: state => state.external.facilities,
    }),
  },
  methods: {
    getFacility() {
      const params = {
        params: {
          lat: this.lat,
          lng: this.lng,
        }
      }
      this.$store.dispatch('external/getFacility', params)
    },
    showDefImg(event) {
      event.target.src = this.defImg
    },
    getFacilityImg(value) {
      const code = value.code
      const defImg = value.leadImage === null ? this.defImg : value.leadImage
      const imgPath =
        code === '0304001'
        ? this.hotel
        : code === '0422003'
        ? this.administration
        : code === '0424002'
        ? this.shrine
        : code === '0419001'
        ? this.beautySalon
        : code === '0106001'
        ? this.noodle
        : code === '207007'
        ? this.flower
        : defImg
      return imgPath
    }
  }
}
</script>