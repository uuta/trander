<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small p-setting__wrap">
        <div class="c-head_title__big">設定 - Setting</div>
        <i class="fas fa-arrow-left p-setting__back" @click.self="hiddenSettingModal"></i>
        <div class="p-setting__distance__wrap">
          <div class="p-setting__distance__info">
            <p class="c-head_title__mid c-head_title__bold no__margin">次の地点までの距離</p>
            <p class="no__margin">{{ setDistance[0] }}km - {{ setDistance[1] }}km</p>
          </div>
        </div>
        <div class="p-setting__vue-slider">
          <vue-slider
            ref="slider"
            v-model="setDistance"
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
        <button class="button button--link p-setting__elm__wrap" @click="logout">
          <div class="p-setting__icon"><i class="fas fa-sign-out-alt"></i></div>
          <p class="p-setting__txt">ログアウト</p>
          <i class="fas fa-caret-right p-setting__next"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapMutations, mapGetters } from 'vuex'

  import vueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  import { DISTANCE_MSG } from '../../util'

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
      },
      logout () {
        const router = this.$router
        this.$store.dispatch('auth/logout', router)
      }
    }
  }
</script>