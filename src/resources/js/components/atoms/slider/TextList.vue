<template>
  <dd class="c-slider_wrap">
    <div class="text_list" v-for="keyword in keywords" :key="keyword" @click="inputKeyword(keyword)">
      <span>{{keyword}}</span>
    </div>
  </dd>
</template>

<script>
export default {
  props: {
    keywords: { type: Array, required: true },
  },
  methods: {
    inputKeyword(keyword) {
      this.$emit("input", keyword);
    }
  }
}
</script>