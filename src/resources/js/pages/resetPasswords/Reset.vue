<template>
  <div class="container">
    <Bars v-show="loading"></Bars>
    <div class="container--small">
        <div class="panel">
          <div class="panel__hr">パスワードのリセット</div>
            <div v-if="resetErrors" class="errors">
              <ul v-if="resetErrors.email">
                <li v-for="msg in resetErrors.email" :key="msg">{{ msg }}</li>
              </ul>
            </div>
            <form class="form" autocomplete="off" @submit.prevent="resetPassword">
              <div class="panel__txt">登録に使用した<strong>Eメールアドレス</strong>を入力してください。パスワードをリセットするためのリンクを記載したEメールをお送りします。</div>
                  <label for="email">メールアドレス</label>
                  <div class="form__wrap">
                    <div class="c-icon__email"></div>
                    <input type="email" id="email" class="form__item" placeholder="user@example.com" v-model="resetForm.email" required>
                  </div>
              <button type="submit" class="button button--inverse">パスワードをリセットする</button>
            </form>
          </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Bars from '../../components/atoms/loader/Bars.vue'

export default {
    components: {
      Bars
    },
    data() {
      return {
        resetForm: {
          email: ''
        }
      }
    },
    computed: mapState({
      resetErrors: state => state.auth.resetErrorMessages,
      loading: state => state.auth.loading
    }),
    methods: {
        resetPassword() {
          const data = this.resetForm
          const router = this.$router
          this.$store.dispatch("auth/resetPassword", {data, router})
        }
    }
}
</script>