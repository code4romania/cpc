@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<section {{ $attributes->merge(['class' => 'bg-white border-b border-[color:var(--color-border)]']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-start gap-4">
            @if ($icon)
                <div class="bg-tint-blue p-3 rounded-lg shrink-0 text-primary">
                    {{ $icon }}
                </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-navy mb-2">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="text-muted">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
