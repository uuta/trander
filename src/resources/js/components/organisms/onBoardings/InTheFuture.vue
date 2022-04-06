<template>
  <div class="wrap">
    <h2 class="title">In the future</h2>
    <div class="flex">
      <div class="flex_item">
        <h3>YouTube integration</h3>
        <img src="/assets/icons/util/youtube.png" />
      </div>
      <div class="flex_item">
        <h3>World wide exploring</h3>
        <img src="/assets/icons/util/earth.png" />
      </div>
      <div class="flex_item">
        <h3>Weather integration</h3>
        <img src="/assets/icons/util/cloudy.png" />
      </div>
      <div class="flex_item">
        <h3>World Heritage searching</h3>
        <img src="/assets/icons/util/stupa.png" />
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.wrap {
  background: #fd026f;
  .flex {
    display: flex;
    justify-content: space-around;
    padding-bottom: 150px;
    padding-right: 60px;
    padding-left: 60px;
    h3 {
      font-size: 1.5rem;
    }
    img {
      width: 150px;
      filter: drop-shadow(10px 10px 20px #40042480);
    }
  }
}
@media screen and (max-width: 480px) {
  .wrap {
    h2 {
      font-size: 2.5rem;
    }
    .flex {
      padding-bottom: 100px;
      .flex_item {
        padding-bottom: 30px;
      }
    }
  }
}
</style>
