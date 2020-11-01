<template>
  <div class="p-map_kw_google_btns">
    <div class="container wide">
      <IconText
        text="ツイートしてシェアする！"
        :image="twitter"
        className="c-wrap_icon_text"
      ></IconText>
    </div>
    <div class="container general">
      <IconText
        text="Google Map"
        :image="googleMap"
        className="c-wrap_icon_text"
      ></IconText>
    </div>
    <div class="container general">
      <IconText
        text="Street View"
        :image="streetView"
        className="c-wrap_icon_text"
      ></IconText>
    </div>
  </div>
</template>

<script>
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
}
</script>
