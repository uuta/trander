<template>
  <button :class="className" class="button_square_text_img button">
    <img v-if="image" :src="image" class="icon" :alt="text"><span class="description">{{text}}</span>
  </button>
</template>

<script>
export default {
  props: {
    text: { type: String, required: true },
    image: { type: String, required: false },
    className: { type: String, required: false },
  },
}
</script>