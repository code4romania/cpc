@props([
    'label' => null,
    'error' => null,
    'placeholder' => null,
])

<div class="space-y-1">
    @if ($label)
        <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-navy">
            {{ $label }}
        </label>
    @endif

    <select {{ $attributes->merge([
        'class' => 'w-full rounded-lg border border-[color:var(--color-border)] bg-surface-muted px-4 py-2.5 text-navy focus:border-accent focus:ring-2 focus:ring-accent/30 focus:outline-none disabled:opacity-50 '.($error ? 'border-destructive' : ''),
    ]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @if ($error)
        <p class="text-sm text-destructive">{{ $error }}</p>
    @endif
</div>
