@props([
    'label' => null,
    'error' => null,
    'hint' => null,
])

<div class="space-y-1">
    @if ($label)
        <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-navy">
            {{ $label }}
        </label>
    @endif

    <input {{ $attributes->merge([
        'class' => 'w-full rounded-lg border border-[color:var(--color-border)] bg-surface-muted px-4 py-2.5 text-navy placeholder:text-muted/70 focus:border-accent focus:ring-2 focus:ring-accent/30 focus:outline-none disabled:opacity-50 '.($error ? 'border-destructive focus:border-destructive focus:ring-destructive/30' : ''),
    ]) }} />

    @if ($error)
        <p class="text-sm text-destructive">{{ $error }}</p>
    @elseif ($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
</div>
