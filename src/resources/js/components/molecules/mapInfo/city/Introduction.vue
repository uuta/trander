<template>
  <dl class="map_info_introduction">
    <dt class="title">知らない街に行ってみよう</dt>
    <dd class="list">
      {{ username }}さん、こんにちは！<br>
      ボタンを押して、近くの街を探してみましょう。
    </dd>
  </dl>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      username: 'auth/username'
    }),
  },
}
</script>