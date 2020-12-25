<template>
  <p class="c-text_rating" :class="color">
    <span class="number">{{rating}}</span>
    <span class="star_wrap"><img :src="ratingImg" :class="color"></span>
    <span class="total_ratings" :class="totalRatingColor">（{{ratingsTotal}}）</span>
  </p>
</template>

<script>
export default {
  name: "Rating",
  props: {
    rating: { type: String, required: true },
    ratingsTotal: { type: String, required: true },
    ratingImg: { type: String, required: true },
    color: { type: String, required: false },
    totalRatingColor: { type: String, required: false },
  },
}
</script>