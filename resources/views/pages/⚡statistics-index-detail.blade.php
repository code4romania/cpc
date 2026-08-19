<?php

use App\Enums\IndexType;
use App\Models\IndexCountyScore;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Monitoring Index')] class extends Component
{
    public IndexType $type;

    public function mount(IndexType|string $type): void
    {
        $this->type = $type instanceof IndexType ? $type : IndexType::from($type);
    }

    /** @return Collection<int, IndexCountyScore> */
    public function scores(): Collection
    {
        return IndexCountyScore::query()
            ->with('county')
            ->where('index_type', $this->type)
            ->orderByDesc('year')
            ->orderByDesc('score')
            ->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="$type->label()" :subtitle="__('statistics.index_detail_subtitle')" />
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ localized_route('statistics.index') }}" class="text-primary hover:text-navy">← {{ __('statistics.back') }}</a>
        <x-ui.card class="p-8 mt-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-sm text-muted border-b border-[color:var(--color-border)]">
                        <tr><th class="py-3">{{ __('statistics.county') }}</th><th>{{ __('statistics.year') }}</th><th>{{ __('statistics.score') }}</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($this->scores() as $score)
                            <tr wire:key="score-{{ $score->id }}" class="border-b border-[color:var(--color-border)]">
                                <td class="py-4 font-medium text-navy">{{ $score->county?->name }}</td>
                                <td class="text-muted">{{ $score->year }}</td>
                                <td class="font-bold text-primary">{{ number_format($score->score, 1) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-12 text-center text-muted">{{ __('statistics.none') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    </main>
</div>
