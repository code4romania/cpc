<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('Login')]
class extends Component
{
    public function mount(): void
    {
        session(['locale' => app()->getLocale()]);
    }
};
?>

<div class="max-w-md w-full">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-tint-blue rounded-full mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-navy mb-2">{{ __('auth.login_title') }}</h1>
        <p class="text-muted">{{ __('auth.login_subtitle') }}</p>
    </div>

    <x-ui.card class="p-8">
        @if ($errors->any())
            <x-ui.alert variant="emergency" class="mb-6">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-6">
            @csrf

            <x-ui.input
                id="email"
                name="email"
                type="email"
                label="{{ __('auth.email') }}"
                value="{{ old('email') }}"
                placeholder="{{ __('auth.email_placeholder') }}"
                required
                autofocus
                autocomplete="username"
                :error="$errors->first('email')"
            />

            <x-ui.input
                id="password"
                name="password"
                type="password"
                label="{{ __('auth.password') }}"
                placeholder="{{ __('auth.password_placeholder') }}"
                required
                autocomplete="current-password"
                :error="$errors->first('password')"
            />

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-navy">
                    <input type="checkbox" name="remember" class="rounded border-[color:var(--color-border)] text-primary focus:ring-accent">
                    {{ __('auth.remember') }}
                </label>
            </div>

            <x-ui.button type="submit" class="w-full">
                {{ __('auth.sign_in') }}
            </x-ui.button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-muted">
                {{ __('auth.no_account') }}
                <a href="{{ localized_route('register') }}" class="text-primary hover:text-navy font-medium">
                    {{ __('auth.register_here') }}
                </a>
            </p>
        </div>
    </x-ui.card>

    <p class="mt-6 text-center text-xs text-muted">
        {!! __('auth.security_notice', [
            'terms' => '<a href="'.e(localized_route('terms')).'" class="text-primary hover:text-navy">'.e(__('auth.terms_link')).'</a>',
            'cookies' => '<a href="'.e(localized_route('cookie-policy')).'" class="text-primary hover:text-navy">'.e(__('auth.cookie_policy')).'</a>',
        ]) !!}
    </p>
</div>
