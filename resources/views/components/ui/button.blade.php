@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-primary text-white hover:bg-navy',
        'secondary' => 'bg-surface-muted text-muted hover:bg-tint-blue hover:text-navy',
        'accent' => 'bg-accent text-white hover:opacity-90',
        'ghost' => 'bg-transparent text-muted hover:bg-surface-muted hover:text-navy',
        'destructive' => 'bg-destructive text-white hover:opacity-90',
        'outline' => 'border border-primary text-primary bg-transparent hover:bg-primary hover:text-white',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-6 py-3 text-sm',
        'lg' => 'px-8 py-4 text-base',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
