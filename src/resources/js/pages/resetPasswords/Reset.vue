<template>
  <div class="container--small">
      <div class="panel">
          <div class="panel__hr">パスワードのリセット</div>
            <form class="form" autocomplete="off" @submit.prevent="resetPassword">
              <div class="panel__txt">登録に使用した<strong>Eメールアドレス</strong>を入力してください。パスワードをリセットするためのリンクを記載したEメールをお送りします。</div>
              <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input type="email" id="email" class="form__item" placeholder="user@example.com" v-model="resetForm.email" required>
              </div>
              <button type="submit" class="button button--inverse">パスワードをリセットする</button>
            </form>
          </div>
  </div>
</template>

<script>
export default {
    data() {
      return {
        resetForm: {
          email: ''
        },
        has_error: false
      }
    },
    methods: {
        resetPassword() {
          const data = this.resetForm
          const router = this.$router
          this.$store.dispatch("auth/resetPassword", {data, router})
            /* this.resetForm.post("auth/resetPassword", {email: this.email}).then(result => {
                this.response = result.data;
                console.log(result.data);
            }, error => {
                console.error(error);
            }); */
        }
    }
}
</script>