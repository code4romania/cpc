@props([
    'variant' => 'default',
])

@php
    $variants = [
        'default' => 'bg-surface-muted text-muted border-[color:var(--color-border)]',
        'primary' => 'bg-tint-blue text-primary border-primary/20',
        'accent' => 'bg-tint-purple text-accent border-accent/20',
        'featured' => 'bg-tint-purple text-accent border-accent/20',
        'navy' => 'bg-tint-blue/50 text-navy border-navy/10',
    ];
@endphp

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border '.($variants[$variant] ?? $variants['default']),
]) }}>
    {{ $slot }}
</span>
