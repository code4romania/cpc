<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Contact')] class extends Component
{
    /**
     * @return list<string>
     */
    public function organizationKeys(): array
    {
        return ['anitp', 'fonpc', 'eliberare', 'tdh', 'world_vision', 'code'];
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('contact.title')" :subtitle="__('contact.subtitle')" />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
        @foreach ($this->organizationKeys() as $key)
            <x-ui.card wire:key="contact-{{ $key }}" class="p-8">
                <h2 class="text-2xl font-bold text-navy mb-4">{{ __("contact.organizations.$key.name") }}</h2>
                <p class="text-navy leading-7">{{ __("contact.organizations.$key.body") }}</p>
                <dl class="mt-5 space-y-2 text-sm">
                    @if (__("contact.organizations.$key.website") !== "contact.organizations.$key.website")
                        <div>
                            <dt class="font-semibold text-navy">{{ __('contact.website') }}</dt>
                            <dd>
                                <a href="{{ __("contact.organizations.$key.website_url") }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-navy">
                                    {{ __("contact.organizations.$key.website") }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if (__("contact.organizations.$key.email") !== "contact.organizations.$key.email")
                        <div>
                            <dt class="font-semibold text-navy">{{ __('contact.email') }}</dt>
                            <dd>
                                <a href="mailto:{{ __("contact.organizations.$key.email") }}" class="text-primary hover:text-navy">
                                    {{ __("contact.organizations.$key.email") }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if (is_array($phones = __("contact.organizations.$key.phones")))
                        @foreach ($phones as $phone)
                            <div>
                                <dt class="font-semibold text-navy">{{ __('contact.phone') }}</dt>
                                <dd class="text-navy">{{ $phone }}</dd>
                            </div>
                        @endforeach
                    @endif
                    @if (__("contact.organizations.$key.note") !== "contact.organizations.$key.note")
                        <p class="text-muted">{{ __("contact.organizations.$key.note") }}</p>
                    @endif
                </dl>
            </x-ui.card>
        @endforeach
    </main>
</div>
