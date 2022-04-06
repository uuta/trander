<template>
  <div class="container p-on_boarding__container">
    <picture>
      <source media="(min-width: 480px)" srcset="/assets/images/top_1.jpg" />
      <img src="/assets/images/top_1_sp.jpg" />
    </picture>
    <div class="p-on_boarding__msg">
      <h1>Discover the unexpected</h1>
      <div class="p-on_boarding__desc">
        <p>Let’s discover the unexpected!</p>
        <p>Get out of our boring daily lives and take off into the world.</p>
      </div>
      <a
        href="https://play.google.com/store/apps/details?id=net.uuta.trander&hl=en-GB&ah=fpxCnhz7bqmIhmtmA3Ir6JgcYBk&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"
        ><img
          alt="Get it on Google Play"
          src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
      /></a>
    </div>
    <div class="p-on_boarding__content container">
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__firstwrap">
          <h2 class="title">What Trander is all about</h2>
          <p>Trander's goal is to create a system that mixes noise with optimized daily life.</p>
          <p>
            At first glance, you might be suggested a residential area that has nothing to do with
            you, a depopulated area in the mountains, or a big city in the concrete jungle.
            Sometimes the name of a city outside the country will be suggested. But that's okay.
          </p>
          <p>
            Let's take the plunge and go out by bicycle, car, or train. You are sure to make some
            unexpected discoveries.
          </p>
          <a
            href="https://play.google.com/store/apps/details?id=net.uuta.trander&hl=en-GB&ah=fpxCnhz7bqmIhmtmA3Ir6JgcYBk&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"
            ><img
              alt="Get it on Google Play"
              src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
          /></a>
        </div>
      </div>
      <in-the-future></in-the-future>
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__bottomwrap">
          <h2 class="title">Developer</h2>
          <div class="form__sns__wrap">
            <a
              class="form__sns__btn"
              href="https://twitter.com/xXxuutaxXx"
              target="”_blank”"
              rel="”noopener”"
              ><i class="fab fa-twitter"></i
            ></a>
            <a
              class="form__sns__btn"
              href="https://www.instagram.com/uuta_aoki/"
              target="”_blank”"
              rel="”noopener”"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import InTheFuture from '@/components/organisms/onBoardings/InTheFuture';

export default {
  components: {
    InTheFuture,
  },
};
</script>

<style lang="scss" scoped>
.p-on_boarding__msg {
  img {
    width: 200px;
  }
}
.p-on_boarding__firstwrap {
  img {
    width: 200px;
  }
}
</style>
