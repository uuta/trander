<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <div class="container--small">
        <p>設定（Setting）</p>
        <p>次の地点までの距離</p>
        <p>3km - 60km</p>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
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