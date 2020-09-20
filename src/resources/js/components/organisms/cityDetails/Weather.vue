<template>
  <div class="contents_wrap recommend">
    <h3 class="title" @click="getWeather">天気予報</h3>
    <div class="slider_wrap">
      <div class="content weather" v-for="weather in weathers">
        <div class="time">
          <span>{{weather.dateTime}}</span>
        </div>
        <picture class="weather_icon">
          <img class="icon" :src="getWeatherImg(weather)" @error="weatherIcon">
        </picture>
        <dl class="info">
          <dt class="description">{{weather.description}}</dt>
          <dd class="temp">{{weather.temp}}℃</dd>
          <dd class="amount">{{getAmount(weather)}}</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  data() {
    return {
      weatherIcon: 'https://openweathermap.org/img/wn/10d@2x.png'
    }
  },
  computed: {
    ...mapState({
      lat: state => state.external.lat,
      lng: state => state.external.lng,
      weathers: state => state.external.weathers,
    }),
  },
  methods: {
    getWeather() {
      const params = {
        params: {
          lat: this.lat,
          lng: this.lng,
        }
      }
      this.$store.dispatch('external/getWeather', params)
    },
    getWeatherImg(value) {
      return value.weatherIcon === null
        ? this.weatherIcon
        : 'https://openweathermap.org/img/wn/' + value.weatherIcon + '@2x.png'
    },
    getAmount(value) {
      return value.rain === null ? null : value.rain + 'mm'
    },
  },
}
</script>