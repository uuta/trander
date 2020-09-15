<template>
  <div class="c-modal__overlay" @click.self="hiddenModal" v-if="errorModal">
    <div class="c-modal__overlay__wrap__sml">
      <div class="c-modal__msg__section error">
        <div>
          <p class="c-head_title__mid__modal"><i class="far fa-smile"></i>以下を確認してください。</p>
            <p v-for="errorMessage in errorMessages">
              {{errorMessage[0]}}
            </p>
        </div>
      </div>
      <button class="button__modal error" @click.self="hiddenModal">OK</button>
    </div>
  </div>
</template>


<script>
import { mapState, mapGetters } from 'vuex'

export default {
  computed: {
    ...mapState({
      errorMessages: state => state.external.errorMessages,
      errorModal: state => state.external.errorModal,
    }),
  },
  methods: {
    hiddenModal() {
      this.$store.commit('external/setErrorModal', false)
    },
  },
}
</script>