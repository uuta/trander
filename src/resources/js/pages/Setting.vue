<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small">
        <h1>設定（Setting）</h1>
        <p>次の地点までの距離</p>
        <vue-slider ref="slider" v-model="value" :enable-cross="false"></vue-slider>
        <p>3km - 60km</p>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  import vueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  export default {
    components: {
      vueSlider
    },
    data () {
      return {
        value: [0, 100],
      }
    },
    computed: mapState({
      settingModal: state => state.external.settingModal,
    }),
    methods: {
      hiddenSettingModal() {
        this.$store.commit('external/setSettingModal', false)
      },
    }
  }
</script>