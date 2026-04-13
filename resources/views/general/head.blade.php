<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <meta name="theme-color" content="#FF5F00">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@isset($seo)
    <meta property="og:title" content="{{$seo->title}}"/>
    <meta property="og:description" content="{{$seo->description}}"/>    
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{env('APP_NAME')}}"/>
    <meta property="og:url" content="{{url()->current()}}" />

    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}"/>
    <meta name="title" content="{{$seo->title}}">
@endisset

@if(isset($_GET['page']))
    <link rel="canonical" href="{{ url(Request::url()) }}" />
@endif

    <link rel="shortcut icon" href="{{ asset('assets/i/favicon.png') }}" type="image/png"/>
    <link rel="shortcut icon" href="{{ asset('assets/i/favicon.svg') }}" type="image/svg+xml"/>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 

@if (request()->routeIs('contacts'))
	<script src="https://api-maps.yandex.ru/2.1/?apikey=@if(isset($metrics->yandex_api) && $metrics->yandex_api){{$metrics->yandex_api}}@endif&lang=ru-RU" type="text/javascript"></script>
@endif

@if (request()->routeIs('one-news') || request()->routeIs('one-article'))
    <script type="text/javascript" src="https://yastatic.net/share2/share.js"></script>
@endif

    <script type="text/javascript" src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>

@if(isset($metrics->head) && !empty($metrics->head))
    {!! $metrics->head !!}
@endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>