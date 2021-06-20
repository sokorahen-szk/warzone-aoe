<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ \Config::get('web.web_site_name') }}</title>
    <meta name="description" itemprop="description" content="{{ \Config::get('web.description') }}">
    <meta name="keywords" itemprop="keywords" content="{{ \Config::get('web.keywords') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:locale" content="{{ \Config::get('web.og.locale') }}">
    <meta property="og:title" content="{{ \Config::get('web.og.title') }}">
    <meta property="og:type" content="{{ \Config::get('web.og.type') }}">
    <meta property="og:site_name" content="{{ \Config::get('web.og.title') }}" />
    <meta property="og:image" content="{{ url(\Config::get('web.og.image')) }}">
    <meta property="og:description" content="{{ \Config::get('web.og.description') }}">
    <link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">
</head>
<body>
    <div id="app"></div>
    <script src="{{ url(mix('/js/app.js')) }}" defer></script>
</body>
</html>
