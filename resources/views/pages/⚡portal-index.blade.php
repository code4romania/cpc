<?php

use App\Models\ProfessionalResource;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Professional Portal')] class extends Component
{
    public function resourceCount(): int
    {
        return ProfessionalResource::published()->count();
    }
};
?>

<div class="min-h-screen bg-background">
    <section class="bg-gradient-to-r from-primary to-navy text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-3xl font-bold">{{ __('portal.title') }}</h1>
            <p class="mt-2 text-white/80">{{ __('portal.subtitle') }}</p>
            <p class="mt-5">{{ __('portal.welcome', ['name' => auth()->user()->name]) }}</p>
        </div>
    </section>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['route' => 'portal.resources', 'title' => 'portal.resources', 'body' => 'portal.resources_body'],
                ['route' => 'portal.consultations.index', 'title' => 'portal.consultations', 'body' => 'portal.consultations_body'],
                ['route' => 'portal.profile', 'title' => 'portal.profile', 'body' => 'portal.profile_body'],
            ] as $item)
                <a wire:key="{{ $item['route'] }}" href="{{ localized_route($item['route']) }}"
                   class="bg-white rounded-xl border border-[color:var(--color-border)] p-6 hover:border-accent hover:shadow-lg">
                    <h2 class="text-xl font-semibold text-navy">{{ __($item['title']) }}</h2>
                    <p class="text-muted mt-2">{{ __($item['body']) }}</p>
                </a>
            @endforeach
        </div>
        <x-ui.card class="p-6 mt-8">
            <h2 class="text-xl font-semibold text-navy">{{ __('portal.account') }}</h2>
            <div class="grid md:grid-cols-3 gap-5 mt-4 text-sm">
                <div><span class="text-muted">{{ __('portal.organization') }}</span><p class="font-medium text-navy">{{ auth()->user()->organization }}</p></div>
                <div><span class="text-muted">{{ __('portal.role') }}</span><p class="font-medium text-navy">{{ auth()->user()->professional_role?->label() }}</p></div>
                <div><span class="text-muted">{{ __('portal.available_resources') }}</span><p class="font-medium text-navy">{{ $this->resourceCount() }}</p></div>
            </div>
        </x-ui.card>
    </main>
</div>
