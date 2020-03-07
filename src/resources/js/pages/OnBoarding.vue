<template>
  <div class="container p-on_boarding__container">
    <picture>
      <source media="(min-width: 480px)" srcset="/assets/images/top_1.jpg">
      <img src="/assets/images/top_1_sp.jpg">
    </picture>
    <div class="p-on_boarding__msg">
      <h1>街を発見しよう。</h1>
      <div class="p-on_boarding__desc">
        <p>つまらない日常を変える都市発見アプリケーション。</p>
        <p>世界各国で利用可能。知らない街を見つけましょう。</p>
      </div>
      <RouterLink class="button button--inverse__top" to="/login">
        ログインする
      </RouterLink>
    </div>
  </div>
</template>