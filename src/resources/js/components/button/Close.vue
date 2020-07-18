<template>
  <button class="button close" @click="closePage()">閉じる</button>
</template>

<script>
export default {
  methods: {
    closePage () {
      window.close()
    }
  }
}
</script>