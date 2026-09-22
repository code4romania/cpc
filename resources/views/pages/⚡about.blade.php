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
                @foreach ([
                    'evidence' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'accessible' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
                    'trauma' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    'child' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                ] as $value => $icon)
                    <x-ui.card wire:key="value-{{ $value }}" class="group p-6 hover:border-accent hover:shadow-lg transition-all">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-4 bg-tint-blue text-primary transition-transform duration-300 group-hover:-translate-y-1 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                            </svg>
                        </div>
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
