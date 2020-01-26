<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small">
        <h1>設定（Setting）</h1>
        <p>次の地点までの距離</p>
        <vue-slider
          ref="slider"
          v-model="setDistance"
          :enable-cross="false"
          :dotSize="20"
          :dotStyle="{ backgroundColor: '#3316F2', borderShadow: '#3316F2', boxShadow: '#3316F2'}"
          :processStyle="{ backgroundColor: '#3316F2' }"
          :tooltipStyle="{ backgroundColor: '#3316F2', borderColor: '#3316F2', borderShadow: '#3316F2' }"
        ></vue-slider>
        <p>{{ setDistance[0] }}km - {{ setDistance[1] }}km</p>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapMutations } from 'vuex'

  import vueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  export default {
    components: {
      vueSlider
    },
    computed: {
      ...mapState({
        settingModal: state => state.external.settingModal
      }),
      setDistance: {
        get() {
          return this.$store.state.external.distance
        },
        set(val) {
          this.updateDistance(val)
        }
      }
    },
    methods: {
      hiddenSettingModal() {
        const distance = {
          min: setDistance[0],
          max: setDistance[1]
        }
        this.$store.dispatch('external/setSetting')
      },
      updateDistance(val){
        this.$store.commit('external/setDistance', val)
      }
    }
  }
</script>