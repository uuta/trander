<template>
  <div class="contents_wrap recommend">
    <h3 class="title">天気予報</h3>
    <div class="slider_wrap">
      <div class="content weather">
        <div class="time">
          <span>2020-09-09 09:00:00</span>
        </div>
        <picture class="weather_icon">
          <img class="icon" :src="weatherIcon">
        </picture>
        <dl class="info">
          <dt class="description">曇りがち</dt>
          <dd class="temp">27.05℃</dd>
          <dd class="amount">3.02mm</dd>
        </dl>
      </div>
      <div class="content weather">
        <div class="time">
          <span>2020-09-09 09:00:00</span>
        </div>
        <picture class="weather_icon">
          <img class="icon" :src="weatherIcon">
        </picture>
        <dl class="info">
          <dt class="description">曇りがち</dt>
          <dd class="temp">27.05℃</dd>
          <dd class="amount">3.02mm</dd>
        </dl>
      </div>
      <div class="content weather">
        <div class="time">
          <span>2020-09-09 09:00:00</span>
        </div>
        <picture class="weather_icon">
          <img class="icon" :src="weatherIcon">
        </picture>
        <dl class="info">
          <dt class="description">曇りがち</dt>
          <dd class="temp">27.05℃</dd>
          <dd class="amount">3.02mm</dd>
        </dl>
      </div>
      <div class="content weather">
        <div class="time">
          <span>2020-09-09 09:00:00</span>
        </div>
        <picture class="weather_icon">
          <img class="icon" :src="weatherIcon">
        </picture>
        <dl class="info">
          <dt class="description">曇りがち</dt>
          <dd class="temp">27.05℃</dd>
          <dd class="amount">3.02mm</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      weatherIcon: 'https://openweathermap.org/img/wn/10d@2x.png'
    }
  },
}
</script>