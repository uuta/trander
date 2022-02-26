<template>
  <div v-if="successful" class="container p-share_kw">
    <div class="head_wrap">
      <div class="inner_item">
        <div class="caption">What might you discover?</div>
        <IconText
          :text="name"
          :image="icon"
          className="c-wrap_icon_text_general large base"
        ></IconText>
      </div>
    </div>
    <div class="content_wrap">
      <IconText
        :text="vicinity"
        :image="vicinityPath"
        className="c-wrap_icon_text_general large"
      ></IconText>
    </div>
    <div class="content_wrap center tall">
      <a
        href="https://play.google.com/store/apps/details?id=net.uuta.trander&hl=en-GB&ah=fpxCnhz7bqmIhmtmA3Ir6JgcYBk&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"
        ><img
          alt="Get it on Google Play"
          src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
      /></a>
    </div>
    <div class="content_wrap">
      <IconText
        text="Trander is an application that randomly suggests nearby cities and tourist spots based on your current location."
        :image="ideaPath"
        className="c-wrap_icon_text_attention"
      ></IconText>
    </div>
    <div class="content_wrap google">
      <h2 class="title">More Exploration</h2>
      <a :href="googleMapUrl" target="_blank" class="link_wrap">
        <IconText
          text="Google Map"
          :image="googleMap"
          className="c-wrap_icon_text_general huge p-share_kw_google"
        ></IconText>
      </a>
      <a :href="streetViewUrl" target="_blank" class="link_wrap">
        <IconText
          text="Google Street View"
          :image="streetView"
          className="c-wrap_icon_text_general huge p-share_kw_google"
        ></IconText>
      </a>
    </div>
    <div class="footer_wrap">
      <a :href="twitterUrl" target="_blank" class="link">
        <img :src="twitter" alt="twitter_icon" class="icon" />
      </a>
    </div>
  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
import IconText from '../components/atoms/container/IconText.vue';
import Rating from '../components/atoms/container/Rating.vue';
import SquareTextImg from '../components/atoms/button/SquareTextImg.vue';

export default {
  data() {
    return {
      twitter: '/assets/icons/kws/twitter_2.svg',
      googleMap: '/assets/icons/kws/google-maps.svg',
      streetView: '/assets/icons/kws/street-view.svg',
    };
  },
  components: {
    IconText,
    Rating,
    SquareTextImg,
  },
  created() {
    this.getGooglePlace();
  },
  computed: {
    ...mapState({
      successful: state => state.kw.successful,
      name: state => state.kw.name,
      vicinity: state => state.kw.vicinity,
      icon: state => state.kw.icon,
      rating: state => state.kw.rating,
      ratingStar: state => state.kw.ratingStar,
      userRatingsTotal: state => state.kw.userRatingsTotal,
      lat: state => state.kw.lat,
      lng: state => state.kw.lng,
    }),
    ratingPath() {
      return '/assets/icons/stars/rating_' + this.ratingStar + '.png';
    },
    vicinityPath() {
      return '/assets/icons/kws/location.png';
    },
    arrowPath() {
      return '/assets/icons/util/dice_2.png';
    },
    ideaPath() {
      return '/assets/icons/util/idea_1.png';
    },
    googleMapUrl() {
      return (
        'https://www.google.com/maps/search/?api=1&query=' +
        this.lat +
        ',' +
        this.lng +
        '&query_place_id=' +
        this.$route.params.placeId
      );
    },
    streetViewUrl() {
      return (
        'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=' + this.lat + ',' + this.lng
      );
    },
    twitterUrl() {
      return 'https://twitter.com/Trander14';
    },
  },
  methods: {
    getGooglePlace() {
      const data = {
        params: {
          placeId: this.$route.params.placeId,
        },
      };
      this.$store.dispatch('kw/getGooglePlace', data);
    },
    resetParam() {
      this.$store.commit('kw/resetParam');
    },
  },
};
</script>

<style scoped lang="scss">
.content_wrap.center.tall {
  img {
    width: 200px;
  }
}
</style>
