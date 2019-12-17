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
        <label for="login-email">お名前</label>
        <input type="text" class="form__item" id="login-name" v-model="registerForm.name" placeholder="例）trander太郎">
        <label for="login-email">メールアドレス</label>
        <input type="email" class="form__item" id="login-email" v-model="registerForm.email" placeholder="PC・スマホどちらでも可">
        <label for="login-password">パスワード</label>
        <input type="password" class="form__item" id="login-password" v-model="registerForm.password"  placeholder="6文字以上の半角英数字">
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
        password: ''
      }
    }
  },
  methods: {
    login () {
      console.log(this.loginForm)
    },
    async register () {
      // authストアのresigterアクションを呼び出す
      await this.$store.dispatch('auth/register', this.registerForm)

      // トップページに移動する
      this.$router.push('/')
    }
  }
}
</script>