<template>
  <div class="p-map_kw_google_btns">
    <div class="container wide">
      <a :href="twitterUrl" target="_blank" class="link">
        <IconText
          text="ツイートしてシェアする！"
          :image="twitter"
          className="c-wrap_icon_text"
        ></IconText>
      </a>
    </div>
    <div class="container general">
      <a :href="googleMapUrl" target="_blank" class="link">
        <IconText
          text="Google Map"
          :image="googleMap"
          className="c-wrap_icon_text"
        ></IconText>
      </a>
    </div>
    <div class="container general">
      <a :href="streetViewUrl" target="_blank" class="link">
        <IconText
          text="Street View"
          :image="streetView"
          className="c-wrap_icon_text"
        ></IconText>
      </a>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import IconText from '../../atoms/container/IconText.vue'

export default {
  data() {
    return {
      twitter: '/assets/icons/kws/twitter_2.svg',
      googleMap: '/assets/icons/kws/google-maps.svg',
      streetView: '/assets/icons/kws/street-view.svg'
    }
  },
  components: {
    IconText,
  },
  computed: {
    ...mapState({
      lat: state => state.kw.lat,
      lng: state => state.kw.lng,
      placeId: state => state.kw.placeId,
    }),
    twitterUrl() {
      return 'https://twitter.com/intent/tweet?text=' + "ツイッターシェアボタンのサンプルコード" + "%20%23あめねこサンプルコード集" + '&url=' + "https://code.ameneko.com/twitter-share"
    },
    googleMapUrl() {
      return 'https://www.google.com/maps/search/?api=1&query=' + this.lat + ',' + this.lng + '&query_place_id=' + this.placeId
    },
    streetViewUrl() {
      return 'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=' + this.lat + ',' + this.lng
    },
  },
}
</script>
