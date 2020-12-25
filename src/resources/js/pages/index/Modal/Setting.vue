<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small p-setting__wrap">
        <div class="top-section"></div>
        <i class="fas fa-arrow-left p-setting__back" @click.self="hiddenSettingModal"></i>
        <div class="p-setting__distance__wrap">
          <div class="p-setting__distance__info">
            <p class="title">次の地点までの距離</p>
            <p class="desc">{{ setRangeOfDistance[0] }}km - {{ setRangeOfDistance[1] }}km</p>
          </div>
        </div>
        <div class="p-setting__vue-slider">
          <vue-slider
            ref="slider"
            v-model="setRangeOfDistance"
            :enable-cross="false"
            :dotSize="20"
            :railStyle="{height: '8px', border: '1px solid #6e5ce8', background: '#fff'}"
            :dotStyle="{ backgroundColor: '#3316F2', borderShadow: '#3316F2', boxShadow: '#3316F2'}"
            :processStyle="{ backgroundColor: '#3316F2' }"
            :tooltipStyle="{ backgroundColor: '#3316F2', borderColor: '#3316F2', borderShadow: '#3316F2' }"
          ></vue-slider>
        </div>
        <div class="p-setting__distance__msg">
          <p class="p-setting__distance__msg__lf">0km</p>
          <p class="p-setting__distance__msg__mid">{{ msg }}</p>
          <p class="p-setting__distance__msg__rf">100km</p>
        </div>
        <Direction></Direction>
        <div class="p-setting__elm">
          <button class="button button--link p-setting__elm__wrap" @click="logout">
            <div class="p-setting__icon"><i class="fas fa-sign-out-alt"></i></div>
            <p class="p-setting__txt">ログアウト</p>
            <i class="fas fa-caret-right p-setting__next"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapMutations, mapGetters } from 'vuex'

  import vueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'
  import Direction from './Setting/Direction.vue'

  import { DISTANCE_MSG } from '../../../util'

  export default {
    components: {
      vueSlider,
      Direction
    },
    computed: {
      ...mapState({
        settingModal: state => state.external.settingModal,
        msg: state => state.external.msg,
        directionType: state => state.external.directionType
      }),
      setRangeOfDistance: {
        get() {
          return this.$store.state.external.rangeOfDistance
        },
        set(rangeOfDistance) {
          this.updateRangeOfDistance(rangeOfDistance)
        }
      }
    },
    methods: {
      hiddenSettingModal() {
        const states = {
          distance: this.setRangeOfDistance,
          directionType: this.directionType
        }
        const parameters = {
          min: this.setRangeOfDistance[0],
          max: this.setRangeOfDistance[1],
          direction_type: this.directionType
        }
        this.$store.dispatch('external/setSetting', {states, parameters})
      },
      updateRangeOfDistance(rangeOfDistance){
        const msg = this.setMsg(rangeOfDistance)
        this.$store.commit('external/setRangeOfDistance', rangeOfDistance)
        this.$store.commit('external/setMsg', msg)
      },
      setMsg(rangeOfDistance) {
        var max = rangeOfDistance[1]
        for (let [standard, msg] of Object.entries(DISTANCE_MSG)) {
          if (max <= standard) {
            return msg
          }
        }
      },
      async logout () {
        const router = this.$router
        this.$store.commit('common/setLoading', true)
        await this.$store.dispatch('auth/logout', router)
        this.$store.commit('common/setLoading', false)
      },
    }
  }
</script>