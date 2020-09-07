import Vue from 'vue'
import router from './router/index'
import App from './App.vue'
import './extension/bootstrap'
import store from './store'
import vueGoogleMaps from './extension/vueGoogleMaps'
import vueProgressBar from './extension//vueProgressBar'
import './extension/tagManager'

const createApp = async () => {
    await store.dispatch('auth/currentUser')

    new Vue({
        el: '#app',
        router,
        store,
        components: {
            App
        },
        template: '<App />'
    })
}

createApp()