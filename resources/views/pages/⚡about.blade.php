<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('About')] class extends Component {};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('about.title')" :subtitle="__('about.subtitle')" />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <x-ui.card class="p-8">
            <h2 class="text-2xl font-bold text-navy mb-4">{{ __('about.mission_title') }}</h2>
            <p class="text-navy leading-7">{{ __('about.mission_body') }}</p>
        </x-ui.card>

        <section>
            <h2 class="text-2xl font-bold text-navy mb-6">{{ __('about.values_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach (['evidence', 'accessible', 'trauma', 'child'] as $value)
                    <x-ui.card wire:key="value-{{ $value }}" class="p-6 hover:border-accent hover:shadow-lg transition-all">
                        <h3 class="text-xl font-semibold text-navy mb-3">{{ __("about.values.$value.title") }}</h3>
                        <p class="text-muted">{{ __("about.values.$value.body") }}</p>
                    </x-ui.card>
                @endforeach
            </div>
        </section>

        <x-ui.card class="p-8">
            <h2 class="text-2xl font-bold text-navy mb-5">{{ __('about.offer_title') }}</h2>
            <div class="space-y-5">
                @foreach (['education', 'tools', 'development', 'cases'] as $offer)
                    <div wire:key="offer-{{ $offer }}">
                        <h3 class="font-semibold text-navy">{{ __("about.offers.$offer.title") }}</h3>
                        <p class="text-muted mt-1">{{ __("about.offers.$offer.body") }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.alert variant="emergency" :title="__('about.notice_title')">
            {{ __('about.notice_body') }}
        </x-ui.alert>

        <section class="rounded-xl bg-accent p-8 text-center text-white">
            <h2 class="text-2xl font-bold">{{ __('about.cta_title') }}</h2>
            <p class="mt-3 mb-6">{{ __('about.cta_body') }}</p>
            <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary">{{ __('about.cta_button') }}</x-ui.button>
        </section>
    </main>
</div>
