import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../pages/Login.vue'
import OnBoarding from '../pages/OnBoarding.vue'
import Index from '../pages/index/Index.vue'
import Setting from '../pages/index/Modal/Setting.vue'

import Reset from '../pages/resetPasswords/Reset.vue'
import SentEmail from '../pages/resetPasswords/SentEmail.vue'
import Regenerate from '../pages/resetPasswords/Regenerate.vue'
import RegenerateComplete from '../pages/resetPasswords/Complete.vue'

import TermsOfService from '../pages/services/TermsOfService.vue'
import PrivacyPolicy from '../pages/services/PrivacyPolicy.vue'

import SystemError from '../pages/errors/System.vue'

import store from '../store'

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
  name: 'index',
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
  path: '/index/:cityId',
  name: 'cityDetail',
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
  path: '/kw',
  name: 'keyword',
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
  path: '/setting',
  component: Setting,
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
  path: '/regenerate-password/:token',
  component: Regenerate,
  beforeEnter(to, from, next) {
    if (store.getters['auth/check']) {
      next('/index')
    } else {
      next()
    }
  }
},
{
  path: '/regenerate-password-complete',
  component: RegenerateComplete,
  beforeEnter(to, from, next) {
    if (store.getters['auth/check']) {
      next()
    } else {
      next('/login')
    }
  }
},
{
  path: '/terms-of-service',
  component: TermsOfService,
},
{
  path: '/privacy-policy',
  component: PrivacyPolicy,
}
]

const router = new VueRouter({
  mode: 'history',
  routes // `routes: routes` の短縮表記
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router