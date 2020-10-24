<template>
  <GeneralInput
    v-model="keyword.text"
    placeholder="Search..."
    name="keyword-input"
    type="text"
  ></GeneralInput>
</template>

<script>
import GeneralInput from '../../../atoms/input/GeneralInput.vue'

export default {
  data() {
    return {
      keyword: {
        text: "",
      },
    }
  },
  components: {
    GeneralInput,
  },
}
</script>