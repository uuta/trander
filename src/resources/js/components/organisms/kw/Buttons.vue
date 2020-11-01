<template>
  <div class="p-map_kw_google_btns">
    <div class="container">
      <IconText
        text="Google Map"
        :image="googleMap"
      ></IconText>
    </div>
    <div class="container">
      <IconText
        text="Street View"
        :image="streetView"
      ></IconText>
    </div>
  </div>
</template>

<script>
import IconText from '../../atoms/container/IconText.vue'

export default {
  data() {
    return {
      googleMap: '/assets/icons/kws/google-maps.svg',
      streetView: '/assets/icons/kws/street-view.svg'
    }
  },
  components: {
    IconText,
  },
}
</script>
