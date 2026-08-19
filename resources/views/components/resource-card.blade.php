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
        'video' => ['icon' => 'video', 'class' => 'bg-tint-purple text-accent'],
        'printable' => ['icon' => 'check', 'class' => 'bg-tint-blue text-primary'],
        'template' => ['icon' => 'clipboard', 'class' => 'bg-tint-purple/70 text-accent'],
        'guide' => ['icon' => 'book', 'class' => 'bg-tint-blue text-primary'],
        'document' => ['icon' => 'file', 'class' => 'bg-surface-muted text-muted'],
        'material' => ['icon' => 'file', 'class' => 'bg-tint-blue/50 text-navy'],
    ];
    $style = $typeStyles[$type] ?? $typeStyles['document'];
@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => 'block bg-white rounded-lg border border-[color:var(--color-border)] p-6 hover:border-accent hover:shadow-lg transition-all']) }}>
    <div class="flex items-start gap-4">
        <div class="p-3 rounded-lg shrink-0 {{ $style['class'] }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
