<template>
  <nav class="map_tab">
    <ul class="lists">
      <li class="list">
        <RouterLink
          :to="{name: 'index'}"
          v-bind:class="{active: searchingUrl === URL_TYPE.CITY}"
          @click.native="changeActive(URL_TYPE.CITY)"
        >
          街検索
        </RouterLink>
      </li>
      <li class="list">
        <RouterLink
          :to="{name: 'keyword'}"
          v-bind:class="{active: searchingUrl === URL_TYPE.KW}"
          @click.native="changeActive(URL_TYPE.KW)"
        >
          キーワード検索
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import { URL_TYPE } from '../../../const/common.js'

export default {
  data() {
    return {
      URL_TYPE,
    }
  },
  computed: {
    ...mapState({
      searchingUrl: state => state.external.searchingUrl,
    }),
  },
  methods: {
    changeActive(value) {
      this.$store.commit('external/setSearchingUrl', value)
    }
  },
}
</script>