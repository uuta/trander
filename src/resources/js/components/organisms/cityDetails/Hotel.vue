<template>
  <div class="contents_wrap recommend">
    <h3 class="title" @click="getHotel">ホテル・宿泊施設（楽天トラベル）</h3>
    <div class="slider_wrap" v-if="hotelsShowing">
      <div class="content hotel" v-for="hotel in hotels">
        <a v-bind:href="hotel.hotelInformationUrl" target="_blank" class="link">
          <picture class="thumbnail position_parent">
            <img class="image" :src="hotel.hotelThumbnailUrl" @error="showDefImg">
            <p class="title position_child">{{hotel.hotelName}}</p>
          </picture>
          <dl class="info">
            <dd class="price">{{getHotelPrice(hotel.hotelMinCharge)}}</dd>
            <dd class="rating">{{hotel.reviewAverage}}</dd>
          </dl>
        </a>
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
      defImg: '/assets/images/hotels/hotel.png',
    }
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      hotels: state => state.external.hotels,
      hotelsShowing: state => state.external.hotelsShowing,
    }),
  },
  methods: {
    getHotel() {
      const params = {
        params: {
          lat: this.lat,
          lng: this.lng,
        }
      }
      this.$store.dispatch('external/getHotel', params)
    },
    showDefImg(event) {
      event.target.src = this.defImg
    },
    getHotelPrice(value) {
      const price = value === null ? '宿泊プランなし' : Number(value).toLocaleString() + '円〜'
      return price
    }
  },
}
</script>