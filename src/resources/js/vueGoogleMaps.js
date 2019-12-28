import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
  load: {
    key: process.env.MIX_API_FOR_GOOGLE_MAPS,
    libraries: 'places'
  }
})