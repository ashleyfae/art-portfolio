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

<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
@vite('resources/js/app.js')

@if(\Illuminate\Support\Facades\Route::currentRouteName() === 'artworks.create' || \Illuminate\Support\Facades\Route::currentRouteName() === 'artworks.edit')
    @vite('resources/js/ckeditor.js')
@endif
</body>
</html>
