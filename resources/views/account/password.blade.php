<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.approved_action') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-background px-4 py-12">
    <div class="max-w-md w-full">
        <x-ui.card class="p-8">
            <h1 class="text-2xl font-bold text-navy mb-2">{{ __('auth.approved_action') }}</h1>
            <p class="text-muted mb-6">{{ __('auth.set_password_body', ['name' => $user->name]) }}</p>
            <form method="POST" action="{{ request()->fullUrl() }}" class="space-y-4">
                @csrf
                <x-ui.input id="password" name="password" type="password" :label="__('auth.password')" required :error="$errors->first('password')" />
                <x-ui.input id="password_confirmation" name="password_confirmation" type="password" :label="__('auth.password_confirmation')" required />
                <x-ui.button type="submit" class="w-full">{{ __('auth.approved_action') }}</x-ui.button>
            </form>
        </x-ui.card>
    </div>
</body>
</html>
