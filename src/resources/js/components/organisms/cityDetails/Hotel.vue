<template>
  <div class="contents_wrap recommend">
    <h3 class="title">ホテル・宿泊施設（楽天トラベル）</h3>
    <div class="slider_wrap">
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="price">1,980円〜</dd>
          <dd class="rating">★★★★☆</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="price">1,980円〜</dd>
          <dd class="rating">★★★★☆</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="price">1,980円〜</dd>
          <dd class="rating">★★★★☆</dd>
        </dl>
      </div>
      <div class="content">
        <picture class="thumbnail">
          <img class="image" :src="thumbnail">
        </picture>
        <dl class="info">
          <dt class="title">前野原温泉 さやの湯処</dt>
          <dd class="price">1,980円〜</dd>
          <dd class="rating">★★★★☆</dd>
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