<?php

use App\Support\LocaleUrl;
use Livewire\Component;

new class extends Component
{
    public bool $mobile = false;

    public function mount(bool $mobile = false): void
    {
        $this->mobile = $mobile;
    }

    public function currentLocale(): string
    {
        return LocaleUrl::currentLocale();
    }
};
?>

<div @class(['relative' => ! $mobile, 'space-y-2' => $mobile]) x-data="{ open: false }">
    @if (! $mobile)
        <button type="button"
                @click="open = !open"
                class="flex items-center gap-2 px-3 py-2 text-muted hover:text-white hover:bg-primary/40 rounded-lg transition-colors border border-primary">
            <span class="text-lg">{{ $this->currentLocale() === 'en' ? '🇬🇧' : '🇷🇴' }}</span>
            <span class="text-sm font-medium uppercase">{{ $this->currentLocale() }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-2 w-40 bg-navy rounded-lg shadow-lg border border-primary py-1 z-50">
            @foreach (config('cpc.supported_locales', ['ro', 'en']) as $locale)
                <a href="{{ locale_switch_url($locale) }}"
                   @class([
                       'w-full flex items-center gap-3 px-4 py-2 text-sm',
                       'bg-primary/40 text-white' => $this->currentLocale() === $locale,
                       'text-muted hover:bg-primary/40 hover:text-white' => $this->currentLocale() !== $locale,
                   ])>
                    <span class="text-lg">{{ $locale === 'en' ? '🇬🇧' : '🇷🇴' }}</span>
                    <span class="font-medium">{{ __('nav.lang_' . $locale) }}</span>
                </a>
            @endforeach
        </div>
    @else
        @foreach (config('cpc.supported_locales', ['ro', 'en']) as $locale)
            <a href="{{ locale_switch_url($locale) }}"
               @class([
                   'w-full flex items-center gap-3 px-3 py-2 text-sm rounded-lg font-medium',
                   'bg-primary text-white' => $this->currentLocale() === $locale,
                   'text-muted hover:bg-primary/40 hover:text-white' => $this->currentLocale() !== $locale,
               ])>
                <span class="text-lg">{{ $locale === 'en' ? '🇬🇧' : '🇷🇴' }}</span>
                <span>{{ __('nav.lang_' . $locale) }}</span>
            </a>
        @endforeach
    @endif
</div>
