<template>
  <div class="container">
    <div class="container--small">
      <div class="panel">
        <div class="panel__hr">パスワードの再設定完了</div>
        <div class="panel__txt">{{user}}さん、おかえりなさい！パスワードの再設定が完了しました。引き続きTranderをお楽しみいただけます。<RouterLink to="/index">こちらのページ</RouterLink>から探索を始めてみましょう。</div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$store.getters['auth/username']
    }
  }
}
</script>