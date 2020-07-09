<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/ fb# prefix属性: http://ogp.me/ns/ prefix属性#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="{{ config('app.url') }}/assets/images/ogp.jpg" />
    <meta name="description" content="{{ config('const.meta_description') }}">
    <meta property="og:title" content="{{ config('app.name') }} | {{ config('const.title_description') }}" />
    <meta property="og:description" content="{{ config('const.meta_description') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:type" content="{{ config('const.og_type') }}" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:site" content="@Yutti_Onioni" />
    <title>{{ config('app.name') }} | {{ config('const.title_description') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/749149a409.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Roboto:400">
    <link rel="stylesheet" href="https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ config('app.url') }}/assets/images/favicon.ico">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N3KPTLQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="app"></div>
</body>

</html>