<template>
  <div class="container--small">
      <div class="panel">
          <div class="panel__hr">パスワードのリセット</div>
            <form autocomplete="off" @submit.prevent="regeneratePassword">
                  <label for="email">メールアドレス</label>
                  <input type="email" id="email" class="form__item" placeholder="パスワードを新たに設定するメールアドレスを入力" v-model="regenerateForm.email" required>
                  <label for="email">パスワード</label>
                  <input type="password" id="password" class="form__item" placeholder="6文字以上の半角英数字" v-model="regenerateForm.password" required>
                  <label for="email">パスワード (確認)</label>
                  <input type="password" id="password_confirmation" class="form__item" placeholder="6文字以上の半角英数字" v-model="regenerateForm.password_confirmation" required>
              <button type="submit" class="button button--inverse">パスワードを新たに作成する</button>
            </form>
          </div>
        </div>
</template>

<script>
export default {
  data() {
    return {
      token: null,
      regenerateForm: {
        email: null,
        password: null,
        password_confirmation: null,
      },
      has_error: false
    }
  },
  methods: {
    regeneratePassword() {
      const data = this.regenerateForm
      const router = this.$router
      this.$store.dispatch("auth/regeneratePassword", {data, router})
      /*
      this.$http.post("/auth/reset/password/", {
          token: this.$route.params.token,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
      })
      .then(result => {
          // console.log(result.data);
          this.$router.push({name: 'login'})
      }, error => {
          console.error(error);
      });
      */
    }
  }
}
</script>