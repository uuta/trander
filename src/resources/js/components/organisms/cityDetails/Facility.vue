<template>
  <div class="contents_wrap">
    <h3 class="title">周辺施設</h3>
    <div class="slider_wrap">
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="genre">1,980円〜</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="genre">1,980円〜</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="genre">1,980円〜</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="genre">1,980円〜</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      thumbnail: 'https://source.unsplash.com/featured/?tokyo'
    }
  },
}
</script>