<?php

use App\Enums\ProfessionalRole;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('Register')]
class extends Component
{
    public function mount(): void
    {
        session(['locale' => app()->getLocale()]);
    }

    /**
     * @return array<string, string>
     */
    public function professionalRoles(): array
    {
        return ProfessionalRole::options();
    }
};
?>

<div class="max-w-2xl w-full">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-tint-blue rounded-full mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-navy mb-2">{{ __('auth.register_title') }}</h1>
        <p class="text-muted">{{ __('auth.register_subtitle') }}</p>
    </div>

    <x-ui.card class="p-8">
        @if ($errors->any())
            <x-ui.alert variant="emergency" class="mb-6">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">

            <div class="grid md:grid-cols-2 gap-6">
                <x-ui.input
                    id="name"
                    name="name"
                    type="text"
                    label="{{ __('auth.name') }} *"
                    value="{{ old('name') }}"
                    placeholder="{{ __('auth.name_placeholder') }}"
                    required
                    autofocus
                    autocomplete="name"
                    :error="$errors->first('name')"
                />

                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    label="{{ __('auth.email') }} *"
                    value="{{ old('email') }}"
                    placeholder="{{ __('auth.email_placeholder') }}"
                    required
                    autocomplete="username"
                    :error="$errors->first('email')"
                />
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <x-ui.input
                    id="organization"
                    name="organization"
                    type="text"
                    label="{{ __('auth.organization') }} *"
                    value="{{ old('organization') }}"
                    placeholder="{{ __('auth.organization_placeholder') }}"
                    required
                    :error="$errors->first('organization')"
                />

                <x-ui.select
                    id="professional_role"
                    name="professional_role"
                    label="{{ __('auth.professional_role') }} *"
                    placeholder="{{ __('auth.professional_role_placeholder') }}"
                    required
                    :error="$errors->first('professional_role')"
                >
                    @foreach ($this->professionalRoles() as $value => $label)
                        <option value="{{ $value }}" @selected(old('professional_role') === $value)>{{ $label }}</option>
                    @endforeach
                </x-ui.select>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    label="{{ __('auth.password') }} *"
                    placeholder="{{ __('auth.password_min_placeholder') }}"
                    required
                    autocomplete="new-password"
                    :error="$errors->first('password')"
                />

                <x-ui.input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    label="{{ __('auth.password_confirmation') }} *"
                    placeholder="{{ __('auth.password_confirmation_placeholder') }}"
                    required
                    autocomplete="new-password"
                />
            </div>

            <label class="flex items-start gap-2 text-sm text-navy">
                <input type="checkbox" name="terms" value="1" required class="mt-1 rounded border-[color:var(--color-border)] text-primary focus:ring-accent" @checked(old('terms'))>
                <span>
                    {!! __('auth.terms_agree', [
                        'terms' => '<a href="'.e(localized_route('terms')).'" class="text-primary hover:text-navy">'.e(__('auth.terms_link')).'</a>',
                    ]) !!}
                </span>
            </label>
            @error('terms')
                <p class="text-sm text-destructive">{{ $message }}</p>
            @enderror

            <x-ui.button type="submit" class="w-full">
                {{ __('auth.create_account') }}
            </x-ui.button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-muted">
                {{ __('auth.have_account') }}
                <a href="{{ localized_route('login') }}" class="text-primary hover:text-navy font-medium">
                    {{ __('auth.sign_in_here') }}
                </a>
            </p>
        </div>
    </x-ui.card>
</div>
