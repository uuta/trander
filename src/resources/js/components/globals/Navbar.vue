<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      <img src="/assets/images/logo.png" />
    </RouterLink>
    <div class="navbar__menu">
      <span v-if="isLogin" class="navbar__item">
        {{ username }}
      </span>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    isLogin() {
      return this.$store.getters['auth/check'];
    },
    username() {
      return this.$store.getters['auth/username'];
    },
  },
};
</script>
