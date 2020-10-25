<template>
  <GeneralInput
    :value="keyword"
    placeholder="Search..."
    name="keyword-input"
    type="text"
    @input="updateKeyword"
  ></GeneralInput>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import GeneralInput from '../../../atoms/input/GeneralInput.vue'

export default {
  components: {
    GeneralInput,
  },
  computed: {
    ...mapState({
      keyword: state => state.kw.keyword,
    })
  },
  methods: {
    updateKeyword(e) {
      this.$store.commit('kw/setKeyword', e)
    },
  },
}
</script>