@props([
    'label',
    'value',
    'suffix' => null,
    'tone' => 'primary',
])

@php
    $containerClasses = match ($tone) {
        'accent' => 'bg-gradient-to-br from-tint-purple to-surface-muted',
        'muted' => 'bg-gradient-to-br from-surface-muted to-tint-blue/30',
        'navy' => 'bg-gradient-to-br from-surface-muted to-tint-purple/30',
        default => 'bg-gradient-to-br from-tint-blue to-surface-muted',
    };

    $valueClasses = match ($tone) {
        'accent' => 'text-accent',
        'muted' => 'text-muted',
        'navy' => 'text-navy',
        default => 'text-primary',
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg p-6 text-center '.$containerClasses]) }}>
    <div class="text-4xl font-bold mb-2 tabular-nums {{ $valueClasses }}">
        {{ $value }}@if($suffix)<span class="text-2xl">{{ $suffix }}</span>@endif
    </div>
    <div class="text-sm text-navy font-medium">{{ $label }}</div>
</div>
