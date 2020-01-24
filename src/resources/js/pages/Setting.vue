<template>
  <div id="map_overlay" v-if="settingModal" @click.self="hiddenSettingModal">
    <div id="map_overlay_wrap">
      <h1>Setting</h1>
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