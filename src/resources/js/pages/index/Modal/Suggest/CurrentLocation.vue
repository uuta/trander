<template>
  <div class="c-modal__overlay" @click.self="hiddenModal">
    <div class="c-modal__overlay__wrap__sml">
      <div class="c-modal__msg__section">
        <div v-if="geoLocationSetting === SUGGEST.BROWSER">
          <p class="c-head_title__mid__modal">未対応のブラウザのようです</p>
          <p>Tranderを使用するために、</p>
          <p>別なブラウザでログインの上お試しください。</p>
        </div>
        <div v-if="geoLocationSetting === SUGGEST.PERMISSION">
          <p class="c-head_title__mid__modal">現在地の共有設定がOFFです</p>
          <p>Tranderを使用するには、</p>
          <p>共有設定をONにする必要があります。</p>
          <p><button class="button link" type="button" @click="moveLink(`/privacy-policy`)">
              プライバシーポリシー</button
            >を確認する。</p>
        </div>
        <div v-if="geoLocationSetting === SUGGEST.UNAVAILABLE">
          <p class="c-head_title__mid__modal">現在位置が取得できませんでした</p>
          <p>電波の状況が悪い可能性があります。</p>
          <p>開けた場所に移動し再度お試しください。</p>
        </div>
        <div v-if="geoLocationSetting === SUGGEST.TIMEOUT">
          <p class="c-head_title__mid__modal">タイムアウトになりました</p>
          <p>電波の状況が悪い可能性があります。</p>
          <p>開けた場所に移動し再度お試しください。</p>
        </div>
        <div v-if="geoLocationSetting === SUGGEST.SUGGEST">
          <p class="c-head_title__mid__modal">現在地の共有設定を変更しましょう</p>
          <p>現在地の共有設定を「許可」にする必要があります。</p>
          <p>
            <button class="button link" type="button" @click="moveLink(`/privacy-policy`)">
              プライバシーポリシー</button
            >を確認する。
          </p>
        </div>
      </div>
      <button class="button__modal" @click.self="hiddenModal">OK</button>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex';
import CONST_EXTERNAL from '../../../../const/external.js';

export default {
  created: function() {
    this.SUGGEST = CONST_EXTERNAL.CURRENT_LOCATION_SUGGEST;
  },
  computed: {
    ...mapState({
      geoLocationSetting: state => state.external.geoLocationSetting,
    }),
  },
  methods: {
    hiddenModal() {
      this.$store.commit('external/setGeoLocationModal', false);
    },
    moveLink(url) {
      window.open(url, '_blank');
    },
  },
};
</script>
