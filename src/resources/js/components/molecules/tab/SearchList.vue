<template>
  <nav class="map_tab">
    <ul class="lists">
      <li class="list">
        <RouterLink
          :to="{name: 'index'}"
          v-bind:class="{active: isActive === URL_TYPE.CITY}"
          @click.native="changeActive(URL_TYPE.CITY)"
        >
          街検索
        </RouterLink>
      </li>
      <li class="list">
        <RouterLink
          :to="{name: 'keyword'}"
          v-bind:class="{active: isActive === URL_TYPE.KW}"
          @click.native="changeActive(URL_TYPE.KW)"
        >
          キーワード検索
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>

<script>
import { URL_TYPE } from '../../../const/common.js'

export default {
  data() {
    return {
      isActive: null,
      URL_TYPE,
    }
  },
  created() {
    this.isActive = this.$route.path.indexOf('index') != -1
      ? this.URL_TYPE.CITY
      : this.URL_TYPE.KW
  },
  methods: {
    changeActive(value) {
      this.isActive = value
    }
  },
}
</script>