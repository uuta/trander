<template>
  <footer class="footer">
    <button v-if="isLogin" class="button button--link" @click="logout">Logout</button>
    <RouterLink v-else class="button button--link" to="/login">
      Login / Register
    </RouterLink>
  </footer>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    logout () {
      const data = this.loginForm
      const router = this.$router
      // authストアのlogoutアクションを呼び出す
      this.$store.dispatch('auth/logout', router)
    }
  }
}
</script>