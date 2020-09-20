<template>
  <div class="contents_wrap p-wiki">
    <ul class="summary">
      <li class="item">
        <p @click="getWiki">人口</p>
        <i class="fas fa-users icon"></i>
        <p class="info">{{setPopulation}}</p>
      </li>
      <li class="item">
        <p>面積</p>
        <i class="fas fa-chart-area icon"></i>
        <p class="info">{{setArea}}</p>
      </li>
      <li class="item">
        <p>成立年</p>
        <i class="fas fa-book-reader icon"></i>
        <p class="info">{{setInception}}</p>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  data() {
    return {
      thumbnail: 'https://source.unsplash.com/featured/?tokyo',
    }
  },
  computed: {
    ...mapState({
      wiki: state => state.external.wiki,
      wikiDataId: state => state.external.wikiDataId,
    }),
    setPopulation: function() {
      return this.wiki === null ? '-' : Number(this.wiki.population).toLocaleString() + '人'
    },
    setArea: function() {
      return this.wiki === null ? '-' : Number(this.wiki.area).toLocaleString() + 'km'
    },
    setInception: function() {
      return this.wiki === null ? '-' : this.wiki.inception
    },
  },
  methods: {
    getWiki() {
      const params = {
        params: {
          wikiId: this.wikiDataId,
        }
      }
      this.$store.dispatch('external/getWiki', params)
    },
  }
}
</script>