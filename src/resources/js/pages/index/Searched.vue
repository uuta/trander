<template>
  <div class="c-modal__overlay" v-if="modal" @click.self="hiddenModal">
    <div class="c-modal__overlay__wrap__sml">
      <div class="c-modal__msg__section">
        <div>
          <dl v-if="cityName" class="c-head_title__mid__modal">
            <dt><i class="fas fa-crown"></i>近くの街を見つけました！</dt>
            <dd>
              <img :src="setCountryImg" class="country_flag">
              <span class="desc">{{region + " " + cityName }}</span>
            </dd>
          </dl>
          <p> 早速、冒険に出てみましょう！</p>
        </div>
      </div>
      <button class="button__modal" @click.self="hiddenModal">OK</button>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      cityName: state => state.external.cityName,
      region: state => state.external.region,
      countryCode: state => state.external.countryCode,
      modal: state => state.external.modal,
    }),
    setCountryImg: function() {
      if (this.countryCode != null) {
        return 'https://www.countryflags.io/' + this.countryCode + '/flat/32.png'
      }
    }
  },
  methods: {
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    }
  }
}
</script>