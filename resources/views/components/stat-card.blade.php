@props([
    'label',
    'value',
    'suffix' => null,
    'tone' => 'primary',
    'animate' => false,
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

<div {{ $attributes->merge(['class' => 'rounded-lg p-6 text-center '.$containerClasses]) }}
    @if ($animate) data-count-up="{{ (int) $value }}" @endif
    @if ($animate)
        x-data="{ current: 0, target: {{ (int) $value }} }"
        x-init="(() => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const run = () => {
                if (reduceMotion) {
                    current = target;
                    return;
                }
                const duration = 1200;
                const startedAt = performance.now();
                const step = (now) => {
                    const progress = Math.min((now - startedAt) / duration, 1);
                    current = Math.round(target * (1 - Math.pow(1 - progress, 3)));
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                };
                requestAnimationFrame(step);
            };
            const observer = new IntersectionObserver((entries) => {
                if (entries.some((entry) => entry.isIntersecting)) {
                    run();
                    observer.disconnect();
                }
            }, { threshold: 0.4 });
            observer.observe($el);
        })()"
    @endif
>
    <div class="text-4xl font-bold mb-2 tabular-nums {{ $valueClasses }}">
        @if ($animate)
            <span x-text="new Intl.NumberFormat(@js(app()->getLocale())).format(current)">{{ number_format((int) $value) }}</span>
        @else
            {{ $value }}
        @endif
        @if($suffix)<span class="text-2xl">{{ $suffix }}</span>@endif
    </div>
    <div class="text-sm text-navy font-medium">{{ $label }}</div>
</div>
