<template>
  <div class="container">
    <Bars v-show="loading"></Bars>
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
        <form class="form" name="form" @submit.prevent="login">
          <div v-if="loginErrors" class="errors">
            <ul v-if="loginErrors.email">
              <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="loginErrors.password">
              <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </div>
          <label for="login-email">メールアドレス</label>
          <div class="form__wrap">
            <div class="c-icon__email"></div>
            <input type="email" name="email" class="form__item" id="login-email" v-model="loginForm.email" placeholder="PC・スマホどちらでも可">
          </div>
          <label for="login-password">パスワード</label>
          <div class="form__wrap">
            <div class="c-icon__pwd"></div>
            <input type="password" class="form__item" id="login-password" v-model="loginForm.password"  placeholder="6文字以上の半角英数字">
          </div>
          <RouterLink to="/reset-password" class="panel__txt__right">
            パスワードをお忘れですか？
          </RouterLink>
          <div class="form__sns__wrap">
            <a class="form__sns__btn" href="/api/social/twitter"><i class="fab fa-twitter"></i></a>
            <a class="form__sns__btn" href="/api/social/facebook"><i class="fab fa-facebook-f"></i></a>
            <a class="form__sns__btn" href="/api/social/google"><i class="fab fa-google"></i></a>
          </div>
          <div class="form__button">
            <button type="submit" class="button button--inverse">ログインする</button>
          </div>
        </form>
      </div>
      <div class="panel" v-show="tab === 2">
        <div class="panel__hr">会員登録しましょう</div>
        <div class="panel__txt">こんにちは！もしよろしければあなたのことを教えてください。<br>以下の4つの項目を埋めるだけで<strong>会員登録は完了</strong>です。</div>
        <form class="form" @submit.prevent="register">
          <div v-if="registerErrors" class="errors">
            <ul v-if="registerErrors.name">
              <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="registerErrors.email">
              <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="registerErrors.password">
              <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </div>
          <label for="username">お名前</label>
          <div class="form__wrap">
            <div class="c-icon__name"></div>
            <input type="text" class="form__item" id="username" v-model="registerForm.name" placeholder="例）Trander太郎">
          </div>
          <label for="email">メールアドレス</label>
          <div class="form__wrap">
            <div class="c-icon__email"></div>
            <input type="text" class="form__item" id="email" v-model="registerForm.email" placeholder="PC・スマホどちらでも可">
          </div>
          <label for="password">パスワード</label>
          <div class="form__wrap">
            <div class="c-icon__pwd"></div>
            <input type="password" class="form__item" id="password" v-model="registerForm.password" placeholder="6文字以上の半角英数字">
          </div>
          <label for="password-confirmation">パスワード (確認)</label>
          <div class="form__wrap">
            <div class="c-icon__pwd"></div>
            <input type="password" class="form__item" id="password-confirmation" v-model="registerForm.password_confirmation" placeholder="6文字以上の半角英数字">
          </div>
          <div class="list-menu">
            <ul><label><input type="checkbox"><button class="button link" type="button" @click="moveLink(`/terms-of-service`)">利用規約</button>に同意する</label></ul>
            <ul><label><input type="checkbox"><button class="button link" type="button" @click="moveLink(`/privacy-policy`)">プライバシーポリシー</button>に同意する</label></ul>
          </div>
          <div class="form__button">
            <button type="submit" class="button button--inverse">
              <span>会員登録する</span>
              </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Bars from '../components/loader/Bars.vue'

export default {
  components: {
    Bars
  },
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
  computed: mapState({
    loginErrors: state => state.auth.loginErrorMessages,
    registerErrors: state => state.auth.registerErrorMessages,
    loading: state => state.auth.loading
  }),
  methods: {
    login () {
      const data = this.loginForm
      const router = this.$router
      this.$store.dispatch('auth/login', {data, router})
      this.$store.commit('external/setSuggestPushing', true)
    },
    register () {
      const data = this.registerForm
      const router = this.$router
      this.$store.dispatch('auth/register', {data, router})
    },
    clearError () {
      this.$store.commit('auth/setLoginErrorMessages', null)
      this.$store.commit('auth/setRegisterErrorMessages', null)
    },
    moveLink (url) {
      window.open(url, '_blank')
    }
  },
  created () {
    this.clearError()
  }
}
</script>