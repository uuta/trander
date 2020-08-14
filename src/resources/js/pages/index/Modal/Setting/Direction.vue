<template>
  <div class="p-setting__elm">
    <button class="button button--link p-setting__elm__wrap" @click="setSettingDirection">
      <div class="p-setting__icon"><i class="fas fa-map-marker-alt"></i></div>
      <dl class="p-setting__txt">
        <dt>向き</dt>
        <dd>{{setDirectionText}}</dd>
      </dl>
      <i class="fas p-setting__next" :class="setSettingIcon"></i>
    </button>
    <div class="p-select-overlay" v-if="settingDirection">
      <dl class="wrap">
        <dd class="item" v-for="DIRECTION_TYPE in DIRECTION_TYPES" :key="DIRECTION_TYPE.NUM">
          <button :class="{'active': directionType === DIRECTION_TYPE.NUM}" @click="setDirectionType(DIRECTION_TYPE.NUM)">{{DIRECTION_TYPE.TEXT}}</button>
        </dd>
      </dl>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { DIRECTION_TYPE } from '../../../../const/external'
import { Setting } from '../../../../extension/Setting.js'

export default {
  created: function() {
    this.DIRECTION_TYPES = DIRECTION_TYPE
    this.setting = new Setting()
  },
  computed: {
    ...mapState({
      directionType: state => state.external.directionType,
      settingDirection: state => state.external.settingDirection,
    }),
    setDirectionText() {
      return this.setting.setDirectionText(this.directionType)
    },
    setSettingIcon() {
      return this.setting.judgeSettingIcon(this.settingDirection)
    }
  },
  methods: {
    setDirectionType(directionType) {
      this.$store.dispatch('external/setDirectionType', directionType)
    },
    setSettingDirection() {
      const showing = this.settingDirection ? false : true
      this.$store.commit('external/setSettingDirection', showing)
    },
  }
}
</script>