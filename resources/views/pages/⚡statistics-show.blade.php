<?php

use App\Models\StatisticDataset;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Statistics')] class extends Component
{
    public StatisticDataset $dataset;

    public function mount(string $slug): void
    {
        $this->dataset = StatisticDataset::published()
            ->with(['dataPoints' => fn ($query) => $query->orderBy('sort_order')])
            ->where('slug', $slug)
            ->firstOrFail();
    }
};
?>

<div class="min-h-screen bg-background">
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ localized_route('statistics.index') }}" class="text-primary hover:text-navy">← {{ __('statistics.back') }}</a>
        <header class="my-8">
            <h1 class="text-4xl font-bold text-navy">{{ $dataset->title }}</h1>
            <p class="text-lg text-muted mt-3">{{ $dataset->description }}</p>
        </header>

        <x-ui.card class="p-8">
            @php($maximum = max(1, (float) $dataset->dataPoints->max('value')))
            <div class="space-y-5">
                @foreach ($dataset->dataPoints as $point)
                    <div wire:key="point-{{ $point->id }}">
                        <div class="flex justify-between gap-4 text-sm mb-2">
                            <span class="font-medium text-navy">{{ $point->label }}</span>
                            <span class="font-bold text-primary">{{ number_format($point->value, 2) }}</span>
                        </div>
                        <div class="h-4 bg-surface-muted rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: {{ min(100, ($point->value / $maximum) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        @if ($dataset->narrative)
            <x-ui.card class="p-8 mt-8">
                <h2 class="text-2xl font-bold text-navy mb-4">{{ __('statistics.interpretation') }}</h2>
                <p class="text-muted whitespace-pre-line leading-7">{{ $dataset->narrative }}</p>
            </x-ui.card>
        @endif
    </main>
</div>
