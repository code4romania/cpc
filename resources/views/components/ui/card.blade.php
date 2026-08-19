@props([
    'featured' => false,
    'padding' => true,
])

<div {{ $attributes->merge([
    'class' => 'bg-white rounded-lg border transition-all '.($featured ? 'border-accent shadow-md' : 'border-[color:var(--color-border)] hover:border-accent hover:shadow-lg').($padding ? ' p-6' : ''),
]) }}>
    {{ $slot }}
</div>
