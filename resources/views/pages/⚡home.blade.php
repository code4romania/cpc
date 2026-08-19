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
        return Resource::featured()->published()->latest('published_at')->limit(3)->get();
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
                <p class="text-xl md:text-2xl mb-8 text-muted">{{ __('home.hero_subtitle') }}</p>
                <div class="flex flex-wrap gap-4">
                    <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary">{{ __('home.explore') }}</x-ui.button>
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
                    ['bg' => 'bg-tint-blue', 'color' => 'text-primary', 'title' => 'home.feat_edu_title', 'desc' => 'home.feat_edu_desc'],
                    ['bg' => 'bg-tint-purple', 'color' => 'text-accent', 'title' => 'home.feat_tools_title', 'desc' => 'home.feat_tools_desc'],
                    ['bg' => 'bg-surface-muted', 'color' => 'text-muted', 'title' => 'home.feat_org_title', 'desc' => 'home.feat_org_desc'],
                    ['bg' => 'bg-tint-blue/50', 'color' => 'text-navy', 'title' => 'home.feat_stats_title', 'desc' => 'home.feat_stats_desc'],
                ] as $card)
                    <div class="group text-center border border-[color:var(--color-border)] rounded-xl p-6 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:border-accent">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 {{ $card['bg'] }} {{ $card['color'] }}">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy mb-2 group-hover:text-accent transition-colors">{{ __($card['title']) }}</h3>
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
                <x-stat-card :label="__('home.stat_cases')" :value="number_format($statCases)" tone="primary" />
                <x-stat-card :label="__('home.stat_victims')" :value="number_format($statVictims)" tone="accent" />
                <x-stat-card :label="__('home.stat_conviction')" :value="$statConviction" suffix="%" tone="muted" />
                <x-stat-card :label="__('home.stat_recovered')" :value="$statRecovered" suffix="%" tone="navy" />
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
