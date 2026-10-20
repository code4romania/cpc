<?php

use App\Enums\ChartType;
use App\Models\StatisticDataset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Lang;
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

    public function chartTitle(StatisticDataset $dataset): string
    {
        $key = 'statistics.charts.'.$dataset->slug;

        return Lang::has($key) ? __($key) : (string) $dataset->title;
    }

    public function embedCode(string $url, string $title): string
    {
        return '<iframe src="'.$url.'" title="'.e($title).'" style="width: 100%; height: 420px; border: 0;"></iframe>';
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('statistics.title')" :subtitle="__('statistics.subtitle')" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">
        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($this->datasets()->filter(fn (StatisticDataset $dataset): bool => $dataset->chart_type === ChartType::Number)->values() as $summary)
                @php
                    $styles = [
                        ['valueClass' => 'text-primary', 'iconClass' => 'bg-tint-blue text-primary', 'icon' => 'alert'],
                        ['valueClass' => 'text-accent', 'iconClass' => 'bg-tint-purple text-accent', 'icon' => 'user'],
                        ['valueClass' => 'text-muted', 'iconClass' => 'bg-tint-blue text-muted', 'icon' => 'shield'],
                        ['valueClass' => 'text-navy', 'iconClass' => 'bg-surface-muted text-navy', 'icon' => 'target'],
                    ];
                    $style = $styles[$loop->index % count($styles)];
                @endphp
                <x-embed-card wire:key="summary-{{ $summary->id }}" floating :embed-code="$this->embedCode(localized_route('statistics.index'), $summary->title)">
                    <h3 class="pr-24 text-sm font-semibold text-navy">{{ $summary->title }}</h3>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <p class="text-4xl font-bold {{ $style['valueClass'] }}">{{ $summary->number_value }}</p>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full {{ $style['iconClass'] }}">
                            @if ($style['icon'] === 'alert')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.3 4.3 2.6 18a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 4.3a2 2 0 0 0-3.4 0Z"/></svg>
                            @elseif ($style['icon'] === 'user')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 8v6M17 11h6"/></svg>
                            @elseif ($style['icon'] === 'shield')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 5 6v6c0 4.5 3 7.5 7 9 4-1.5 7-4.5 7-9V6l-7-3Z"/></svg>
                            @else
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
                            @endif
                        </span>
                    </div>
                    <p class="mt-3 text-sm text-muted">{{ $summary->description }}</p>
                </x-embed-card>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            @forelse ($this->datasets()->filter(fn (StatisticDataset $dataset): bool => $dataset->chart_type !== ChartType::Number) as $dataset)
                <x-embed-card wire:key="dataset-{{ $dataset->id }}" @class(['lg:col-span-2' => $dataset->slug === 'monthly-trends']) :title="$this->chartTitle($dataset)" :embed-code="$this->embedCode(localized_route('statistics.show', ['slug' => $dataset->slug]), $this->chartTitle($dataset))">
                    <a href="{{ localized_route('statistics.show', ['slug' => $dataset->slug]) }}" class="block">
                        <x-statistic-chart :dataset="$dataset" />
                    </a>
                </x-embed-card>
            @empty
                <x-ui.card class="p-10 text-center text-muted lg:col-span-2">{{ __('statistics.none') }}</x-ui.card>
            @endforelse
        </section>

        <section class="flex gap-4 rounded-xl border border-primary/20 bg-tint-blue p-6">
            <svg class="mt-1 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            <div>
                <h2 class="text-lg font-semibold text-navy">{{ __('statistics.embed_banner_title') }}</h2>
                <p class="mt-2 text-sm text-navy">{{ __('statistics.embed_banner_body') }}</p>
                <p class="mt-2 text-sm text-muted">{{ __('statistics.embed_banner_source') }}</p>
            </div>
        </section>
    </main>
</div>
