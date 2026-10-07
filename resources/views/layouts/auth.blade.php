<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ZEROTRAFIC' }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-background">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:px-4 focus:py-2 focus:bg-primary focus:text-white focus:rounded-lg">
        {{ __('general.skip_to_content') }}
    </a>

    <header class="w-full border-b border-[color:var(--color-border)] bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
            <a href="{{ localized_route('home') }}" class="flex items-center gap-2 text-sm font-semibold text-navy hover:text-primary">
                <img src="{{ asset('images/brand/logo.png') }}" alt="" class="h-8 w-8 object-contain">
                {{ __('footer.brand') }}
            </a>
            <livewire:language-switcher />
        </div>
    </header>

    <main id="main-content" class="flex-1 flex items-center justify-center px-4 py-12">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
