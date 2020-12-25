<template>
  <dl class="map_info_introduction p-map_kw">
    <dt class="title">検索キーワードを入力しましょう</dt>
    <dd class="description">今日の行き先はここだ！</dd>
    <Keyword></Keyword>
    <SliderTextList
      :keywords="exKeywords"
      @input="updateKeyword"
    ></SliderTextList>
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
import SliderTextList from '../../atoms/slider/TextList.vue'

export default {
  data() {
    return {
      exKeywords: [
        '観光名所',
        '温泉',
        '焼肉',
        '寺',
        '神社',
        '寿司',
        '公園',
        'カフェ',
      ]
    }
  },
  components: {
    Keyword,
    ValidationCommon,
    SliderTextList,
  },
  computed: {
    ...mapState({
      errorMessages: state => state.kw.errorMessages,
    }),
  },
  methods: {
    updateKeyword(e) {
      this.$store.commit('kw/setKeyword', e)
    },
  },
}
</script>