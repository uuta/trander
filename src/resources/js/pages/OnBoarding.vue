<template>
  <div class="container p-on_boarding__container">
    <picture>
      <source media="(min-width: 480px)" srcset="/assets/images/top_1.jpg">
      <img src="/assets/images/top_1_sp.jpg">
    </picture>
    <div class="p-on_boarding__msg">
      <h1>次なる街はここだ。</h1>
      <div class="p-on_boarding__desc">
        <p>会社と自宅の往復から飛び出すための地域発見アプリ。</p>
        <p>世界各国で利用可能。知らない街を見つけましょう。</p>
      </div>
      <RouterLink class="button button--inverse__top" to="/login">
        ログインする
      </RouterLink>
    </div>
    <div class="p-on_boarding__content container">
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__firstwrap">
          <h2 class="title">Trander（トランダー）とは何か？</h2>
          <p>Trander（トランダー）とは、あなたの現在地を元に近くの街を提案するWEBアプリケーションです。ボタンひとつで簡単に世界の情報を知ることができます。</p>
          <picture>
            <img class="p-on_boarding__image" src="/assets/images/top_main_bottom.jpg" alt="Tranderの機能">
          </picture>
        </div>
      </div>
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__secondwrap">
        <h2 class="title">なぜ知らない街に行くか？</h2>
          <p>家族のいる自宅や同僚や上司と働く会社、通っている学校、同じ友達と遊ぶ時間、行きつけの店、休日のお馴染みの散歩場所。日々の暮らしは、安定的で安心感があります。一方で、代わり映えのしない毎日は、思わぬ発見の機会を逃すかもしれません。「未知」は知る価値があります。</p>
          <p>それでは、どのように「未知」を発見できるでしょうか。実はここにパラドックスがあります。知らないことを知るのは非常に難しいのです。</p>
          <p>たとえば、美味しい夕食を作るため「○○ 作り方」というキーワードでのGoogle検索を考えてみましょう。すでにカレーの絶品の作り方を熟知しているなら、「カレー 作り方」は既知です。一方、美味しい作り方を知らないなら「カレーの作り方」のノウハウはないものの、料理や方法は存在することを認識している状況です。</p>
          <p>では、「ツォイワン 作り方」はどうでしょうか。ツォイワンはモンゴルの代表的な家庭料理のひとつで、ボソボソとした食感の焼きうどんのようです。あなたが存在を認知していないのであれば、「未知」ということになります。</p>
          <p>ここがポイントで、そもそも知らなければ検索することもできないのです。Google検索は、あなたが存在を認識している情報を深堀りするにはとても有効です。しかし、頭の外の情報を手に入れるには事足りません。我々は「既知」の奴隷なのです。</p>
        </div>
      </div>
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__firstwrap">
        <h2 class="title">Tranderが目指すもの</h2>
          <p>Tranderが目指すのは、最適化された日常にノイズを混ぜる仕組みづくりです。</p>
          <p>一見すればあなたに全く関係のない住宅街や山間部の過疎地、コンクリートジャングルの大都市が提案されるかもしれません。ときには国外の街の名前が出ることもあるでしょう。しかし、それでよいのです。自転車や自動車、電車などの手段を使い、思い切って出掛けてみましょう。きっと思わぬ発見があるはずです。</p>
          <picture>
            <img class="p-on_boarding__image" src="/assets/images/top_main_bottom2.jpg" alt="自転車">
          </picture>
          <RouterLink class="button button--inverse__top__bottom" to="/login">
            ログインする
          </RouterLink>
        </div>
      </div>
      <div class="p-on_boarding__wrap">
        <div class="p-on_boarding__bottomwrap">
        <h2 class="title">開発者</h2>
          <p>Yuta Aoki</p>
          <div class="form__sns__wrap">
            <a class="form__sns__btn" href="https://twitter.com/Yutti_Onioni" target=”_blank” rel=”noopener”><i class="fab fa-twitter"></i></a>
            <a class="form__sns__btn" href="https://www.instagram.com/uuta_aoki/" target=”_blank” rel=”noopener”><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>