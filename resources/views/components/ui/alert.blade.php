@props([
    'variant' => 'info',
    'title' => null,
])

@php
    $variants = [
        'info' => ['container' => 'bg-tint-blue border-primary/20', 'title' => 'text-navy', 'body' => 'text-navy', 'icon' => 'text-primary'],
        'warning' => ['container' => 'bg-amber-50 border-amber-200', 'title' => 'text-amber-900', 'body' => 'text-amber-800', 'icon' => 'text-amber-600'],
        'emergency' => ['container' => 'bg-red-50 border-red-200', 'title' => 'text-red-900', 'body' => 'text-red-800', 'icon' => 'text-red-600'],
        'success' => ['container' => 'bg-emerald-50 border-emerald-200', 'title' => 'text-emerald-900', 'body' => 'text-emerald-800', 'icon' => 'text-emerald-600'],
    ];
    $style = $variants[$variant] ?? $variants['info'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border p-4 '.$style['container']]) }} role="alert">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 shrink-0 mt-0.5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            @if ($title)
                <h3 class="font-semibold mb-1 {{ $style['title'] }}">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $style['body'] }}">{{ $slot }}</div>
        </div>
    </div>
</div>
