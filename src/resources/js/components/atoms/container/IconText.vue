<template>
  <div class="c-wrap_icon_text">
    <img :src="image" class="icon" :alt="text"><span class="description">{{text}}</span>
  </div>
</template>

<script>
export default {
  name: "IconText",
  props: {
    text: { type: String, required: true },
    image: { type: String, required: true },
  },
}
</script>
