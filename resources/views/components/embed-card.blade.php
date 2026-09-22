@props([
    'title' => null,
    'embedCode',
    'floating' => false,
])

<div {{ $attributes->merge(['class' => 'relative']) }} x-data="{ showEmbed: false, copied: false }">
    <x-ui.card class="h-full">
        @unless ($floating)
            <div class="flex items-start justify-between gap-3 mb-4">
                <h3 class="text-lg font-semibold text-navy">{{ $title }}</h3>
                <button type="button"
                        @click="showEmbed = !showEmbed"
                        class="flex shrink-0 items-center gap-2 rounded-full bg-tint-purple px-3 py-1.5 text-sm font-medium text-accent transition-colors hover:opacity-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    {{ __('embed.button') }}
                </button>
            </div>
        @else
            <button type="button"
                    @click="showEmbed = !showEmbed"
                    class="absolute top-4 right-4 z-10 flex shrink-0 items-center gap-2 rounded-full bg-tint-purple px-3 py-1.5 text-sm font-medium text-accent transition-colors hover:opacity-90">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                {{ __('embed.button') }}
            </button>
        @endunless

        <div :class="showEmbed ? 'opacity-30' : ''">
            {{ $slot }}
        </div>

        <div x-show="showEmbed" x-cloak class="absolute inset-0 bg-white/95 rounded-lg p-6 flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-navy">{{ __('embed.title') }}</h4>
                <button type="button" @click="showEmbed = false" class="text-muted hover:text-navy" aria-label="Close">✕</button>
            </div>
            <p class="text-sm text-muted mb-3">{{ __('embed.copy_hint') }}</p>
            <div class="relative flex-1 max-h-48">
                <pre class="bg-navy text-background p-4 rounded-lg text-xs overflow-auto h-full"><code>{{ $embedCode }}</code></pre>
                <button type="button"
                        @click="navigator.clipboard.writeText(@js($embedCode)); copied = true; setTimeout(() => copied = false, 2000)"
                        class="absolute top-2 right-2 flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-lg text-white transition-colors"
                        :class="copied ? 'bg-muted' : 'bg-primary hover:bg-navy'">
                    <span x-text="copied ? '{{ __('embed.copied') }}' : '{{ __('embed.copy') }}'"></span>
                </button>
            </div>
            <div class="mt-4 p-3 bg-tint-blue rounded-lg">
                <p class="text-xs text-primary"><strong>{{ __('embed.note_label') }}:</strong> {{ __('embed.note') }}</p>
            </div>
        </div>
    </x-ui.card>
</div>
