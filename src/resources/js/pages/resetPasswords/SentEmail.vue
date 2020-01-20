<template>
  <div class="container">
    <div class="container--small">
      <div class="panel">
        <div class="panel__hr">パスワードリセットメール送信完了</div>
        <p>以下のメールアドレス宛にパスワードをリセットするためのメールをお送りしました！メール本文のリンクから新たにパスワードを設定できます。</p>
        <p>{{ email }}</p>
        <p>メールが届かない場合、以下2点をご確認ください。</p>
        <ul>
          <li>メールが届くまでに数分程度お時間をいただく場合があります。数分経過してもメールが送られてこない場合、再度パスワードをリセットしてください。</li>
          <li>迷惑メールに分類されている場合があります。メールが送られてこない場合、迷惑メールフォルダをご確認ください。</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    email() {
      return this.$store.getters['auth/email']
    }
  }
}
</script>