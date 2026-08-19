<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'CPC') }}</title>
    @isset($metaDescription)
        <meta name="description" content="{{ $metaDescription }}">
    @endisset
    @foreach (config('cpc.supported_locales', ['ro', 'en']) as $altLocale)
        <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ localized_route(Route::currentRouteName() ?? 'home', request()->route()?->parameters() ?? [], $altLocale) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ localized_route(Route::currentRouteName() ?? 'home', request()->route()?->parameters() ?? [], config('cpc.default_locale', 'ro')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-background">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:px-4 focus:py-2 focus:bg-primary focus:text-white focus:rounded-lg">
        {{ __('general.skip_to_content') }}
    </a>

    <x-layout.header />

    <main id="main-content" class="flex-1">
        {{ $slot }}
    </main>

    <x-layout.partners />
    <x-layout.footer />
    <x-cookie-consent />

    @livewireScripts
</body>
</html>
