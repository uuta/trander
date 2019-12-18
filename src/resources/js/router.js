import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Login from './pages/Login.vue'
import OnBoarding from './pages/OnBoarding.vue'
import Index from './pages/Index.vue'

import Reset from './pages/resetPasswords/Reset.vue'
import SentEmail from './pages/resetPasswords/SentEmail.vue'
import Regenerate from './pages/resetPasswords/Regenerate.vue'

import SystemError from './pages/errors/System.vue'

import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

const routes = [{
    path: '/login',
    component: Login,
    beforeEnter(to, from, next) {
        if (store.getters['auth/check']) {
            next('/index')
        } else {
            next()
        }
    }
  },
  {
    path: '/',
    component: OnBoarding,
    beforeEnter(to, from, next) {
        if (store.getters['auth/check']) {
            next('/index')
        } else {
            next()
        }
    }
  },
  {
    path: '/index',
    component: Index,
    beforeEnter(to, from, next) {
        if (store.getters['auth/check']) {
            next()
        } else {
            next('/login')
        }
    }
  },
  {
    path: '/500',
    component: SystemError,
  },
  {
    path: '/reset-password',
    name: 'reset-password',
    component: Reset,
    beforeEnter(to, from, next) {
        if (store.getters['auth/check']) {
            next('/index')
        } else {
            next()
        }
    }
  },
  {
    path: '/sent-email',
    component: SentEmail,
    beforeEnter(to, from, next) {
        if (store.getters['auth/check']) {
            next('/index')
        } else {
            next()
        }
    }
  },
  {
    path: '/reset-password/:token',
    name: 'reset-password-form',
    component: Regenerate
  }
]

const router = new VueRouter({
    mode: 'history',
    routes // `routes: routes` の短縮表記
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router