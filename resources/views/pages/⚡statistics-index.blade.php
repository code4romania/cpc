<?php

use App\Models\StatisticDataset;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Statistics')] class extends Component
{
    /** @return Collection<int, StatisticDataset> */
    public function datasets(): Collection
    {
        return StatisticDataset::published()
            ->with(['dataPoints' => fn ($query) => $query->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('statistics.title')" :subtitle="__('statistics.subtitle')" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <x-stat-card :label="__('statistics.total_cases')" value="823" tone="primary" />
            <x-stat-card :label="__('statistics.victims')" value="1,247" tone="accent" />
            <x-stat-card :label="__('statistics.conviction')" value="78" suffix="%" tone="muted" />
            <x-stat-card :label="__('statistics.recovered')" value="89" suffix="%" tone="navy" />
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold text-navy mb-2">{{ __('statistics.indexes_title') }}</h2>
            <p class="text-muted mb-6">{{ __('statistics.indexes_subtitle') }}</p>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([
                    ['route' => 'statistics.index-vulnerability', 'key' => 'vulnerability', 'value' => '58.3'],
                    ['route' => 'statistics.index-resilience', 'key' => 'resilience', 'value' => '67.5'],
                    ['route' => 'statistics.index-rti', 'key' => 'rti', 'value' => '47.9'],
                ] as $index)
                    <a wire:key="index-{{ $index['key'] }}" href="{{ localized_route($index['route']) }}"
                       class="block bg-white rounded-xl border border-[color:var(--color-border)] p-6 hover:border-accent hover:shadow-lg">
                        <h3 class="text-lg font-semibold text-navy">{{ __("statistics.indexes.{$index['key']}") }}</h3>
                        <p class="text-4xl font-bold text-primary my-4">{{ $index['value'] }}</p>
                        <span class="text-accent font-semibold">{{ __('statistics.view_details') }} →</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-navy mb-6">{{ __('statistics.datasets') }}</h2>
            <div class="grid lg:grid-cols-2 gap-6">
                @forelse ($this->datasets() as $dataset)
                    <a wire:key="dataset-{{ $dataset->id }}" href="{{ localized_route('statistics.show', ['slug' => $dataset->slug]) }}"
                       class="bg-white rounded-xl border border-[color:var(--color-border)] p-6 hover:border-accent hover:shadow-lg">
                        <h3 class="text-xl font-semibold text-navy">{{ $dataset->title }}</h3>
                        <p class="text-muted mt-2">{{ $dataset->description }}</p>
                        <div class="flex items-end gap-2 h-28 mt-6" aria-hidden="true">
                            @php($maximum = max(1, (float) $dataset->dataPoints->max('value')))
                            @foreach ($dataset->dataPoints->take(12) as $point)
                                <div class="flex-1 bg-primary rounded-t" style="height: {{ max(6, ($point->value / $maximum) * 100) }}%"></div>
                            @endforeach
                        </div>
                    </a>
                @empty
                    <x-ui.card class="lg:col-span-2 p-10 text-center text-muted">{{ __('statistics.none') }}</x-ui.card>
                @endforelse
            </div>
        </section>
    </main>
</div>
