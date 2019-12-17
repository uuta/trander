<template>
  <div class="container--small">
    <ul class="tab">
      <li
        class="tab__item"
        :class="{'tab__item--active': tab === 1}"
        @click="tab = 1"
      >ログイン</li>
      <li
        class="tab__item"
        :class="{'tab__item--active': tab === 2}"
        @click="tab = 2"
      >会員登録</li>
    </ul>
    <div class="panel" v-show="tab === 1">
      <form class="form" @submit.prevent="login">
        <label for="login-email">メールアドレス</label>
        <input type="email" class="form__item" id="login-email" v-model="loginForm.email" placeholder="PC・スマホどちらでも可">
        <label for="login-password">パスワード</label>
        <input type="password" class="form__item" id="login-password" v-model="loginForm.password"  placeholder="6文字以上の半角英数字">
        <div class="form__button">
          <button type="submit" class="button button--inverse">ログインする</button>
        </div>
      </form>
    </div>
    <div class="panel" v-show="tab === 2">
      <form class="form" @submit.prevent="register">
        <label for="username">お名前</label>
        <input type="text" class="form__item" id="username" v-model="registerForm.name" placeholder="例）Trander太郎">
        <label for="email">メールアドレス</label>
        <input type="text" class="form__item" id="email" v-model="registerForm.email" placeholder="PC・スマホどちらでも可">
        <label for="password">パスワード</label>
        <input type="password" class="form__item" id="password" v-model="registerForm.password" placeholder="6文字以上の半角英数字">
        <label for="password-confirmation">パスワード (確認)</label>
        <input type="password" class="form__item" id="password-confirmation" v-model="registerForm.password_confirmation" placeholder="6文字以上の半角英数字">
        <div class="form__button">
          <button type="submit" class="button button--inverse">会員登録する</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  computed: {
    apiStatus () {
      return this.$store.state.auth.apiStatus
    }
  },
  methods: {
    login () {
      const data = this.loginForm
      const router = this.$router
      // authストアのloginアクションを呼び出す
      this.$store.dispatch('auth/login', {data, router})
      if (this.apiStatus) { this.$router.push('/')}
    },
    register () {
      const data = this.registerForm
      const router = this.$router
      // authストアのresigterアクションを呼び出す
      this.$store.dispatch('auth/register', {data, router})
    }
  }
}
</script>