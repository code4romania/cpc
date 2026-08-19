<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('general.page_not_found') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-background flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <p class="text-6xl font-bold text-primary mb-4">404</p>
        <h1 class="text-2xl font-bold text-navy mb-2">{{ __('general.page_not_found') }}</h1>
        <p class="text-muted mb-6">{{ __('general.page_not_found_desc') }}</p>
        <a href="/{{ config('cpc.default_locale', 'ro') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-navy transition-colors">
            {{ __('general.back_home') }}
        </a>
    </div>
</body>
</html>
