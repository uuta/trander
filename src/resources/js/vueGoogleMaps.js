import * as VueGoogleMaps from '~/node_modules/vue2-google-maps'

Vue.use(VueGoogleMaps, {
  load: {
    key: env('API_FOR_GOOGLE_MAPS'),
    libraries: 'places'
  }
})