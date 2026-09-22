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
            <x-statistic-chart :dataset="$dataset" />
        </x-ui.card>

        @if ($dataset->narrative)
            <x-ui.card class="p-8 mt-8">
                <h2 class="text-2xl font-bold text-navy mb-4">{{ __('statistics.interpretation') }}</h2>
                <p class="text-muted whitespace-pre-line leading-7">{{ $dataset->narrative }}</p>
            </x-ui.card>
        @endif
    </main>
</div>
