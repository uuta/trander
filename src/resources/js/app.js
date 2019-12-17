import Vue from 'vue'
import router from './router'
import App from './App.vue'
import './bootstrap'
import store from './store'

new Vue({
    el: '#app',
    router, // ルーティングの定義を読み込む
    store,
    components: {
        App
    }, // ルートコンポーネントの使用を宣言する
    template: '<App />' // ルートコンポーネントを描画する
})