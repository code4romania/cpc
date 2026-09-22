<?php

use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('CPC')] class extends Component
{
    public int $statCases = 823;

    public int $statVictims = 1247;

    public int $statConviction = 78;

    public int $statRecovered = 89;

    /** @return Collection<int, Resource> */
    public function featuredResources(): Collection
    {
        return Resource::featured()->published()->latest('published_at')->limit(6)->get();
    }
};
?>

<div class="min-h-screen bg-background">
    {{-- Hero --}}
    <section class="relative bg-gradient-to-br from-navy to-primary text-white overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-30"
             style="background-image: url('https://images.unsplash.com/photo-1565963925388-7565b9e00b83?auto=format&fit=crop&w=1080&q=80')"></div>
        <div class="absolute inset-0 bg-navy/78"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-12 h-12 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <h1 class="text-4xl md:text-5xl font-bold">{{ __('home.hero_title') }}</h1>
                </div>
                <p class="text-xl md:text-2xl mb-8 text-white">{{ __('home.hero_subtitle') }}</p>
                <div class="flex flex-wrap gap-4">
                    <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary" class="!text-navy">{{ __('home.explore') }}</x-ui.button>
                    <x-ui.button href="{{ localized_route('about') }}" variant="accent">{{ __('home.learn_more') }}</x-ui.button>
                </div>
            </div>
        </div>
    </section>

    {{-- Emergency banner --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <x-ui.alert variant="emergency" :title="__('home.emergency_title')">
            {{ __('home.emergency_text') }}
            <strong>{{ config('cpc.emergency_hotline', '112') }}</strong>.
        </x-ui.alert>
    </div>

    {{-- Features --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-navy mb-12 text-center">{{ __('home.features_title') }}</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([
                    ['icon' => 'book', 'bg' => 'bg-tint-blue', 'color' => 'text-primary', 'title' => 'home.feat_edu_title', 'desc' => 'home.feat_edu_desc'],
                    ['icon' => 'download', 'bg' => 'bg-tint-purple', 'color' => 'text-accent', 'title' => 'home.feat_tools_title', 'desc' => 'home.feat_tools_desc'],
                    ['icon' => 'building', 'bg' => 'bg-tint-directory', 'color' => 'text-muted', 'title' => 'home.feat_org_title', 'desc' => 'home.feat_org_desc'],
                    ['icon' => 'chart', 'bg' => 'bg-tint-stats', 'color' => 'text-navy', 'title' => 'home.feat_stats_title', 'desc' => 'home.feat_stats_desc'],
                ] as $card)
                    <div data-feature-icon="{{ $card['icon'] }}" class="group cursor-default text-center border border-[color:var(--color-border)] rounded-xl p-6 transition-all duration-300 hover:scale-[1.06] hover:shadow-2xl hover:border-accent hover:bg-background">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg {{ $card['bg'] }} {{ $card['color'] }}">
                            @if ($card['icon'] === 'book')
                                <svg class="icon-book h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v14"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>
                                </svg>
                            @elseif ($card['icon'] === 'download')
                                <svg class="icon-arrow h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="7 10 12 15 17 10"/>
                                    <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="15" y2="3"/>
                                </svg>
                            @elseif ($card['icon'] === 'building')
                                <svg class="icon-building h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6h4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 10h4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14h4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18h4"/>
                                </svg>
                            @else
                                <svg class="h-8 w-8" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
                                    <rect class="bar-1" x="1" y="14" width="6" height="16" rx="1"/>
                                    <rect class="bar-2" x="9" y="8" width="6" height="22" rx="1"/>
                                    <rect class="bar-3" x="17" y="11" width="6" height="19" rx="1"/>
                                    <rect class="bar-4" x="25" y="4" width="6" height="26" rx="1"/>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold text-navy mb-2 transition-colors duration-300 group-hover:text-accent">{{ __($card['title']) }}</h3>
                        <p class="text-muted">{{ __($card['desc']) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- Featured resources --}}
    <section class="py-16 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-navy">{{ __('home.featured_title') }}</h2>
                <x-ui.button href="{{ localized_route('resources.index') }}" variant="ghost" size="sm">
                    {{ __('home.view_all') }}
                </x-ui.button>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($this->featuredResources() as $resource)
                    <x-resource-card
                        wire:key="featured-resource-{{ $resource->id }}"
                        :title="$resource->title"
                        :description="$resource->description"
                        :author="$resource->author"
                        :type="$resource->type->value"
                        :tags="$resource->tags ?? []"
                        :featured="$resource->featured"
                        :languages="$resource->languageLabels()"
                        :url="localized_route('resources.show', ['slug' => $resource->slug])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-16 bg-white" x-data>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-navy mb-4">{{ __('home.stats_title') }}</h2>
                <p class="text-lg text-muted max-w-3xl mx-auto">{{ __('home.stats_subtitle') }}</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <x-stat-card :label="__('home.stat_cases')" :value="$statCases" tone="primary" animate />
                <x-stat-card :label="__('home.stat_victims')" :value="$statVictims" tone="accent" animate />
                <x-stat-card :label="__('home.stat_conviction')" :value="$statConviction" suffix="%" tone="muted" animate />
                <x-stat-card :label="__('home.stat_recovered')" :value="$statRecovered" suffix="%" tone="navy" animate />
            </div>
            <div class="text-center">
                <x-ui.button href="{{ localized_route('statistics.index') }}" variant="primary">
                    {{ __('home.view_all_stats') }}
                </x-ui.button>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative py-16 text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-navy/95 to-primary/85"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">{{ __('home.cta_title') }}</h2>
            <p class="text-xl text-muted mb-8 max-w-3xl mx-auto">{{ __('home.cta_subtitle') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ localized_route('submit.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white text-navy px-8 py-4 rounded-lg font-semibold hover:bg-background transition-colors">
                    {{ __('home.cta_submit') }}
                </a>
                <a href="{{ localized_route('partners.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-accent text-white px-8 py-4 rounded-lg font-semibold hover:opacity-90 transition-colors border-2 border-white/30">
                    {{ __('home.cta_partners') }}
                </a>
            </div>
        </div>
    </section>
</div>
