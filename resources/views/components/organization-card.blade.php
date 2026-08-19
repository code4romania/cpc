@props([
    'name',
    'description',
    'address',
    'city',
    'state',
    'phone',
    'email',
    'website' => null,
    'hours' => null,
    'services' => [],
    'organizationType' => null,
])

<x-ui.card {{ $attributes }}>
    <div class="mb-4">
        <h3 class="text-xl font-semibold text-navy mb-2">{{ $name }}</h3>
        <p class="text-sm text-muted mb-3">{{ $description }}</p>
    </div>

    <div class="space-y-2 mb-4 text-sm">
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 text-muted shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div>
                <div class="text-navy">{{ $address }}</div>
                <div class="text-muted">{{ $city }}, {{ $state }}</div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            <a href="tel:{{ $phone }}" class="text-primary hover:text-navy">{{ $phone }}</a>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <a href="mailto:{{ $email }}" class="text-primary hover:text-navy break-all">{{ $email }}</a>
        </div>
        @if ($website)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <a href="https://{{ $website }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-navy">{{ $website }}</a>
            </div>
        @endif
        @if ($hours)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-navy">{{ $hours }}</span>
            </div>
        @endif
    </div>

    @if (count($services) > 0)
        <div class="pt-4 border-t border-[color:var(--color-border)]">
            <p class="text-xs font-semibold text-navy uppercase tracking-wide mb-2">{{ __('orgcard.services') }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($services as $service)
                    <x-ui.badge variant="accent">{{ $service }}</x-ui.badge>
                @endforeach
            </div>
        </div>
    @endif
</x-ui.card>
