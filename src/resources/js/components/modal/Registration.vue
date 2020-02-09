<template>
  <div id="map_overlay" v-if="registerModal" @click.self="hiddenRegisterModal">
    <div id="map_overlay_wrap">
      <div class="container--small p-setting__wrap">
        <p>登録できました！</p>
        <p>ありがとうございます◯◯さん。</p>
        <p>旅の準備が整いました。</p>
        <div>OK</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      registerModal: true
    }
  },
  methods: {
    hiddenRegisterModal() {
      this.registerModal = false
    }
  }
}
</script>