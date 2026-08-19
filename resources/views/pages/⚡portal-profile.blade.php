<?php

use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Profile')] class extends Component
{
    public string $name = '';

    public string $organization = '';

    public string $locale = 'ro';

    public bool $saved = false;

    public function mount(): void
    {
        $this->name = auth()->user()->name;
        $this->organization = auth()->user()->organization ?? '';
        $this->locale = auth()->user()->locale;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'locale' => ['required', Rule::in(config('cpc.supported_locales', ['ro', 'en']))],
        ]);

        auth()->user()->update($validated);
        $this->saved = true;
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('portal.profile')" :subtitle="__('portal.profile_body')" />
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($saved)
            <x-ui.alert class="mb-6">{{ __('portal.profile_saved') }}</x-ui.alert>
        @endif
        <form wire:submit="save" class="bg-white rounded-xl border border-[color:var(--color-border)] p-8 space-y-6">
            <x-ui.input wire:model="name" :label="__('portal.name')" required :error="$errors->first('name')" />
            <x-ui.input value="{{ auth()->user()->email }}" :label="__('portal.email')" disabled />
            <x-ui.input wire:model="organization" :label="__('portal.organization')" required :error="$errors->first('organization')" />
            <x-ui.select wire:model="locale" :label="__('portal.locale')" :error="$errors->first('locale')">
                <option value="ro">Română</option>
                <option value="en">English</option>
            </x-ui.select>
            <x-ui.button type="submit">{{ __('portal.save') }}</x-ui.button>
        </form>
    </main>
</div>
