<?php

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Consultations')] class extends Component
{
    /** @return Collection<int, Consultation> */
    public function consultations(): Collection
    {
        return auth()->user()->consultations()
            ->withCount('messages')
            ->latest('updated_at')
            ->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('consultations.title')" :subtitle="__('consultations.subtitle')" />
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-end mb-6">
            <x-ui.button href="{{ localized_route('portal.consultations.create') }}">{{ __('consultations.new') }}</x-ui.button>
        </div>
        <x-ui.card>
            <div class="divide-y divide-[color:var(--color-border)]">
                @forelse ($this->consultations() as $consultation)
                    <a wire:key="consultation-{{ $consultation->id }}" href="{{ localized_route('portal.consultations.show', ['consultation' => $consultation]) }}"
                       class="block p-6 hover:bg-background">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h2 class="font-semibold text-navy">{{ $consultation->subject }}</h2>
                                <p class="text-sm text-muted mt-1">{{ $consultation->category }}</p>
                            </div>
                            <div class="flex gap-2">
                                <x-ui.badge variant="accent">{{ $consultation->status->label() }}</x-ui.badge>
                                <x-ui.badge>{{ $consultation->urgency->label() }}</x-ui.badge>
                            </div>
                        </div>
                        <p class="text-sm text-muted mt-4">{{ __('consultations.messages', ['count' => $consultation->messages_count]) }} · {{ $consultation->updated_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <div class="p-12 text-center text-muted">{{ __('consultations.none') }}</div>
                @endforelse
            </div>
        </x-ui.card>
    </main>
</div>
