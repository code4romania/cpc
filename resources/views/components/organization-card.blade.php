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

@php
    $typeStyles = [
        'public_institution' => 'bg-tint-blue text-primary',
        'ngo' => 'bg-tint-purple text-accent',
        'company' => 'bg-surface-muted text-navy',
        'support_group' => 'bg-tint-blue/40 text-primary',
    ];
    $typeIcons = [
        'public_institution' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        'ngo' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        'company' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'support_group' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    ];
    $typeClass = $typeStyles[$organizationType] ?? 'bg-surface-muted text-muted';
    $typeIcon = $typeIcons[$organizationType] ?? $typeIcons['ngo'];
@endphp

<x-ui.card {{ $attributes }}>
    <div class="mb-4 flex items-start gap-4">
        <div data-organization-icon="{{ $organizationType }}" class="p-3 rounded-lg shrink-0 {{ $typeClass }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcon }}"/>
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-semibold text-navy mb-2">{{ $name }}</h3>
            <p class="text-sm text-muted mb-3">{{ $description }}</p>
        </div>
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
