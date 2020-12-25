<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <title>{{$title}}</title>
    <meta property="og:title" content="{{$title}}">
    <meta property="og:image" content="{{$image_url}}">
    <meta property="og:description" content="{{$description}}">
    <meta property="og:url" content="{{ config('app.url') }}" >
    <meta property="og:type" content="{{ config('const.og_type') }}" >
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="fb:app_id" content="1502996483181400" />
    <meta property="twitter:site" content="@Trander14" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{$title}}">
    <meta property="twitter:image" content="{{$image_url}}">
    <meta property="twitter:description" content="{{$description}}">

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