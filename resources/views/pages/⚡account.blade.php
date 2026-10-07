<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Account')] class extends Component
{
    public string $email = '';

    public string $currentPassword = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public string $deletePassword = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->isApprovedOrganizationAccount(), 403);

        $this->email = (string) auth()->user()->email;
    }

    public function updateEmail(): void
    {
        $user = auth()->user();

        $validated = $this->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update(['email' => $validated['email']]);
        session()->flash('status', __('auth.email_updated'));
    }

    public function updatePassword(): void
    {
        $user = auth()->user();

        $this->validate([
            'currentPassword' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'same:passwordConfirmation'],
        ]);

        $user->update(['password' => $this->password]);
        $this->reset('currentPassword', 'password', 'passwordConfirmation');
        session()->flash('status', __('auth.password_updated'));
    }

    public function deleteAccount(): void
    {
        $this->validate([
            'deletePassword' => ['required', 'current_password'],
        ]);

        $user = auth()->user();
        Auth::logout();
        $user->delete();

        $this->redirect(localized_route('home'));
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('auth.account_title')" />
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
        @if (session('status'))
            <x-ui.alert variant="success" :title="session('status')" />
        @endif

        <x-ui.card class="p-8 space-y-3">
            <h2 class="text-xl font-semibold text-navy">{{ auth()->user()->name }}</h2>
            <p class="text-muted">{{ auth()->user()->organization }} · {{ auth()->user()->role->label() }}</p>
            @if (auth()->user()->expires_at)
                <p class="text-sm text-navy">{{ __('auth.expires_on', ['date' => auth()->user()->expires_at->translatedFormat('j F Y')]) }}</p>
            @endif
        </x-ui.card>

        <x-ui.card class="p-8">
            <form wire:submit="updateEmail" class="space-y-4">
                <x-ui.input id="account-email" type="email" wire:model="email" :label="__('auth.email')" :error="$errors->first('email')" />
                <x-ui.button type="submit">{{ __('auth.update_email') }}</x-ui.button>
            </form>
        </x-ui.card>

        <x-ui.card class="p-8">
            <form wire:submit="updatePassword" class="space-y-4">
                <x-ui.input id="current-password" type="password" wire:model="currentPassword" :label="__('auth.current_password')" :error="$errors->first('currentPassword')" />
                <x-ui.input id="new-password" type="password" wire:model="password" :label="__('auth.password')" :error="$errors->first('password')" />
                <x-ui.input id="new-password-confirmation" type="password" wire:model="passwordConfirmation" :label="__('auth.password_confirmation')" />
                <x-ui.button type="submit">{{ __('auth.update_password') }}</x-ui.button>
            </form>
        </x-ui.card>

        <x-ui.card class="p-8">
            <form wire:submit="deleteAccount" class="space-y-4">
                <p class="text-navy">{{ __('auth.delete_account_body') }}</p>
                <x-ui.input id="delete-password" type="password" wire:model="deletePassword" :label="__('auth.current_password')" :error="$errors->first('deletePassword')" />
                <x-ui.button type="submit" variant="destructive">{{ __('auth.delete_account') }}</x-ui.button>
            </form>
        </x-ui.card>
    </main>
</div>
