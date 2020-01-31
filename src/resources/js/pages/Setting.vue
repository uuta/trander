<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small">
        <h1>設定（Setting）</h1>
        <p>次の地点までの距離</p>
        <p>{{ setDistance[0] }}km - {{ setDistance[1] }}km</p>
        <vue-slider
          ref="slider"
          v-model="setDistance"
          :enable-cross="false"
          :dotSize="20"
          :dotStyle="{ backgroundColor: '#3316F2', borderShadow: '#3316F2', boxShadow: '#3316F2'}"
          :processStyle="{ backgroundColor: '#3316F2' }"
          :tooltipStyle="{ backgroundColor: '#3316F2', borderColor: '#3316F2', borderShadow: '#3316F2' }"
        ></vue-slider>
        <p>{{ msg }}</p>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapMutations } from 'vuex'

  import vueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  import { DISTANCE_MSG } from '../util'

  export default {
    components: {
      vueSlider
    },
    computed: {
      ...mapState({
        settingModal: state => state.external.settingModal,
        msg: state => state.external.msg
      }),
      setDistance: {
        get() {
          return this.$store.state.external.distance
        },
        set(distance) {
          this.updateDistance(distance)
        }
      }
    },
    methods: {
      hiddenSettingModal() {
        const distance = this.setDistance
        const setting = {
          lat: this.setDistance[0],
          lng: this.setDistance[1]
        }
        this.$store.dispatch('external/setSetting', {distance, setting})
      },
      updateDistance(distance){
        const msg = this.setMsg(distance)
        this.$store.commit('external/setDistance', distance)
        this.$store.commit('external/setMsg', msg)
      },
      setMsg(distance) {
        var max = distance[1]
        for (let [standard, msg] of Object.entries(DISTANCE_MSG)) {
          if (max <= standard) {
            return msg
          }
        }
      }
    }
  }
</script>