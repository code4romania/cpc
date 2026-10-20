<?php

use App\Models\StaticPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Contact')] class extends Component
{
    /**
     * @return list<string>
     */
    private bool $pageLoaded = false;

    private ?StaticPage $page = null;

    public function pageCopy(): ?StaticPage
    {
        if (! $this->pageLoaded) {
            $this->page = StaticPage::query()->published()->where('slug', 'contact')->first();
            $this->pageLoaded = true;
        }

        return $this->page;
    }

    public function organizationKeys(): array
    {
        return ['anitp', 'fonpc', 'eliberare', 'tdh', 'world_vision', 'code'];
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header
        :title="$this->pageCopy()?->title ?: __('contact.title')"
        :subtitle="trim(strip_tags((string) ($this->pageCopy()?->body ?: __('contact.subtitle'))))"
    />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
        <x-support-lines />

        @foreach ($this->organizationKeys() as $key)
            @php
                $page = $this->pageCopy();
                $website = page_text($page, "org_{$key}_website", "contact.organizations.$key.website");
                $email = page_text($page, "org_{$key}_email", "contact.organizations.$key.email");
                $phones = page_lines($page, "org_{$key}_phones", "contact.organizations.$key.phones");
                $note = page_text($page, "org_{$key}_note", "contact.organizations.$key.note");
            @endphp
            <x-ui.card wire:key="contact-{{ $key }}" class="p-8">
                <h2 class="text-2xl font-bold text-navy mb-4">{{ page_text($page, "org_{$key}_name", "contact.organizations.$key.name") }}</h2>
                <p class="text-navy leading-7">{{ page_text($page, "org_{$key}_body", "contact.organizations.$key.body") }}</p>
                <dl class="mt-5 space-y-2 text-sm">
                    @if ($website !== '' && $website !== "contact.organizations.$key.website")
                        <div>
                            <dt class="font-semibold text-navy">{{ page_text($page, 'website', 'contact.website') }}</dt>
                            <dd>
                                <a href="{{ page_text($page, "org_{$key}_website_url", "contact.organizations.$key.website_url") }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-navy">
                                    {{ $website }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if ($email !== '' && $email !== "contact.organizations.$key.email")
                        <div>
                            <dt class="font-semibold text-navy">{{ page_text($page, 'email', 'contact.email') }}</dt>
                            <dd>
                                <a href="mailto:{{ $email }}" class="text-primary hover:text-navy">
                                    {{ $email }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @foreach ($phones as $phone)
                        <div wire:key="phone-{{ $key }}-{{ md5($phone) }}">
                            <dt class="font-semibold text-navy">{{ page_text($page, 'phone', 'contact.phone') }}</dt>
                            <dd class="text-navy">{{ $phone }}</dd>
                        </div>
                    @endforeach
                    @if ($note !== '' && $note !== "contact.organizations.$key.note")
                        <p class="text-muted">{{ $note }}</p>
                    @endif
                </dl>
            </x-ui.card>
        @endforeach

        <section class="rounded-xl bg-accent p-8 text-center text-white">
            <h2 class="text-2xl font-bold">{{ page_text($this->pageCopy(), 'partnership_title', 'partnership.cta_title') }}</h2>
            <p class="mt-3 mb-6">{{ page_text($this->pageCopy(), 'partnership_body', 'partnership.cta_body') }}</p>
            <x-ui.button href="{{ localized_route('partnership.index') }}" variant="secondary">{{ page_text($this->pageCopy(), 'partnership_button', 'partnership.cta_button') }}</x-ui.button>
        </section>
    </main>
</div>
