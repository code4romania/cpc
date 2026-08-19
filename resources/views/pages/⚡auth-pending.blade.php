<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('Pending verification')]
class extends Component
{
    public function mount(): void
    {
        abort_unless(auth()->check(), 403);

        $user = auth()->user();

        if ($user?->isVerifiedProfessional()) {
            $this->redirect(localized_route('portal.index'), navigate: true);
        }
    }
};
?>

<div class="max-w-md w-full">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-tint-blue rounded-full mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-navy mb-2">{{ __('auth.pending_title') }}</h1>
    </div>

    <x-ui.card class="p-8 space-y-6">
        <x-ui.alert variant="info">
            {{ __('auth.pending_body') }}
        </x-ui.alert>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <x-ui.button :href="localized_route('home')" variant="outline">
                {{ __('auth.back_home') }}
            </x-ui.button>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <x-ui.button type="submit" variant="secondary" class="w-full">
                    {{ __('auth.pending_logout') }}
                </x-ui.button>
            </form>
        </div>
    </x-ui.card>
</div>
