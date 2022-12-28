<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(\Illuminate\Support\Facades\Config::get('app.noindex'))
        <meta name="robots" content="noindex">
    @endif

    <title>{{ $title ?? 'Artwork by Ashley Gibson' }}</title>

    @vite('resources/css/app.css')
</head>
<body class="{{ $bodyClass ?? '' }}">
@yield('body')

@vite('resources/js/app.js')
</body>
</html>
