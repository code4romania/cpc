<?php

use App\Models\PartnerOrganization;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Partners')] class extends Component
{
    /** @return Collection<int, PartnerOrganization> */
    public function partners(): Collection
    {
        return PartnerOrganization::published()->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('partners.organizations_title')" :subtitle="__('partners.organizations_subtitle')" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-2 gap-8">
            @forelse ($this->partners() as $partner)
                <x-ui.card wire:key="partner-{{ $partner->id }}" class="p-6">
                    <div class="flex flex-col sm:flex-row items-start gap-6">
                        @if ($partner->logo_path)
                            <div class="w-32 h-32 shrink-0 bg-background rounded-lg p-4 flex items-center justify-center">
                                <img src="{{ asset('storage/'.$partner->logo_path) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-semibold text-navy">{{ $partner->name }}</h2>
                            <p class="text-muted mt-3 leading-6">{{ $partner->description }}</p>
                            @if ($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="inline-block mt-4 text-primary font-semibold">
                                    {{ __('partners.visit') }} →
                                </a>
                            @endif
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="md:col-span-2 p-12 text-center text-muted">{{ __('partners.none') }}</x-ui.card>
            @endforelse
        </div>
    </main>
</div>
