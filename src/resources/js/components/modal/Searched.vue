<template>
  <div class="c-modal__overlay" v-if="modal" @click.self="hiddenModal">
    <div class="c-modal__overlay__wrap__sml">
      <div class="c-modal__msg__section">
        <div>
          <p class="c-head_title__mid__modal"><i class="fas fa-crown"></i> 近くの都市を発見しました。</p>
          <p v-if="cityName">
            {{ cityName }}
          </p>
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
      modal: state => state.external.modal,
    })
  },
  methods: {
    hiddenModal() {
      this.$store.commit('external/setModal', false)
    }
  }
}
</script>