<template>
  <div class="c-modal__overlay" v-if="registerModal" @click.self="hiddenRegisterModal">
    <div class="c-modal__overlay__wrap__sml">
        <div class="c-modal__msg__section">
          <div>
          <p class="c-head_title__mid__modal">登録できました！</p>
          <p>ありがとうございます{{ username }}さん。</p>
          <p>旅の準備が整いました。</p>
          </div>
        </div>
        <button class="button__modal" @click.self="hiddenRegisterModal">OK</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState({
      registerModal: state => state.auth.registerModal,
      username: state => state.auth.user
    }),
    username() {
      return this.$store.getters['auth/username']
    }
  },
  methods: {
    hiddenRegisterModal() {
      this.$store.dispatch('auth/hiddenRegisterModal')
      this.$store.commit('external/setSuggestPushing', true)
    }
  }
}
</script>