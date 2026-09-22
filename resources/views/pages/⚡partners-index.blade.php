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
                    <div class="flex items-start gap-6">
                        <div class="w-24 h-24 shrink-0 bg-background rounded-lg p-3 flex items-center justify-center border border-[color:var(--color-border)]">
                            @if ($partner->logo_url)
                                <img src="{{ $partner->logo_url }}" alt="" class="max-w-full max-h-full object-contain">
                            @else
                                <span class="text-xs font-semibold text-muted text-center">{{ $partner->name }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xl font-semibold text-navy">{{ $partner->name }}</h2>
                            @if ($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="inline-block mt-1 text-sm text-primary font-semibold break-all hover:text-navy">
                                    {{ $partner->url }}
                                </a>
                            @endif
                            <p class="text-muted mt-3 leading-6 line-clamp-5">{{ $partner->description }}</p>
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="md:col-span-2 p-12 text-center text-muted">{{ __('partners.none') }}</x-ui.card>
            @endforelse
        </div>
    </main>
</div>
