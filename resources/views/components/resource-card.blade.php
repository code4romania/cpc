@props([
    'title',
    'description',
    'author',
    'url',
    'type' => 'document',
    'tags' => [],
    'featured' => false,
])

@php
    $typeStyles = [
        'guide' => ['class' => 'bg-tint-blue text-primary', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        'document' => ['class' => 'bg-surface-muted text-navy', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        'video' => ['class' => 'bg-tint-purple text-accent', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
        'printable' => ['class' => 'bg-tint-blue/70 text-primary', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
        'online' => ['class' => 'bg-tint-purple/60 text-navy', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
    ];
    $style = $typeStyles[$type] ?? $typeStyles['document'];
@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => 'block bg-white rounded-lg border border-[color:var(--color-border)] p-6 hover:border-accent hover:shadow-lg transition-all']) }}>
    <div class="flex items-start gap-4">
        <div data-resource-icon="{{ $type }}" class="p-3 rounded-lg shrink-0 {{ $style['class'] }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2 mb-2">
                <h3 class="font-semibold text-navy line-clamp-2">{{ $title }}</h3>
                @if ($featured)
                    <x-ui.badge variant="featured">{{ __('card.featured') }}</x-ui.badge>
                @endif
            </div>
            <p class="text-sm text-muted mb-3 line-clamp-3">{{ $description }}</p>
            @if (count($tags) > 0)
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach (array_slice($tags, 0, 3) as $tag)
                        <x-ui.badge variant="accent">{{ $tag }}</x-ui.badge>
                    @endforeach
                </div>
            @endif
            <div class="flex items-center justify-between text-xs text-muted">
                <span>{{ __('card.author') }}: {{ $author }}</span>
                <span class="text-accent font-semibold">{{ __('card.read_more') }}</span>
            </div>
        </div>
    </div>
</a>
