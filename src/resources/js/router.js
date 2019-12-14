import Vue from 'vue'
import VueRouter from 'vue-router'


// ページコンポーネントをインポートする
import Login from './pages/Login.vue'
import OnBoarding from './pages/OnBoarding.vue'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

const routes = [{
        path: '/login',
        component: Login
    },
    {
        path: '/',
        component: OnBoarding
    }
]

const router = new VueRouter({
    mode: 'history',
    routes // `routes: routes` の短縮表記
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router