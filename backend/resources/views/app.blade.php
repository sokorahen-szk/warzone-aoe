<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ \Config::get('web.web_site_name') }}</title>
    <meta name="description" itemprop="description" content="test">
    <meta name="keywords" itemprop="keywords" content="test">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
    <div id="app"></div>
    <script src="{{ mix('/js/app.js') }}" defer></script>
</body>
</html>