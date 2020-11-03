<template>
  <dl class="map_info_introduction p-map_kw">
    <dt class="title">検索キーワードを入力しましょう</dt>
    <dd class="description">今日の行き先はここだ！</dd>
    <Keyword></Keyword>
    <ValidationCommon
      v-if="errorMessages"
      :errorMessages="errorMessages"
    ></ValidationCommon>
  </dl>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Keyword from '../../molecules/mapInfo/kw/Keyword.vue'
import ValidationCommon from '../../atoms/validations/Common.vue'

export default {
  components: {
    Keyword,
    ValidationCommon,
  },
  computed: {
    ...mapState({
      errorMessages: state => state.kw.errorMessages,
    }),
  },
}
</script>