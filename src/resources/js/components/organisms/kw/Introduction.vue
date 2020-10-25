<template>
  <dl class="map_info_introduction p-map_kw">
    <dt class="title">検索キーワードを入力しましょう</dt>
    <dt class="description">今日の行き先はここだ！</dt>
    <Keyword></Keyword>
  </dl>
</template>

<script>
import { mapGetters } from 'vuex'
import Keyword from '../../molecules/mapInfo/kw/Keyword.vue'

export default {
  components: {
    Keyword,
  },
}
</script>