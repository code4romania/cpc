<section class="bg-white border-t border-[color:var(--color-border)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-navy mb-2">{{ __('partners.title') }}</h2>
            <p class="text-muted">{{ __('partners.subtitle') }}</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-8 items-center">
            @foreach (['eLiberare', 'FONPC', 'Code for Romania', 'Terre des Hommes', 'Romanian Government', 'US State Dept', 'World Vision'] as $partner)
                <div class="flex items-center justify-center p-4 grayscale hover:grayscale-0 transition-all duration-300 opacity-70 hover:opacity-100">
                    <div class="w-full h-16 flex items-center justify-center bg-surface-muted rounded-lg text-xs text-muted font-medium text-center px-2">
                        {{ $partner }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <p class="text-sm text-muted">
                {{ __('partners.cta') }}
                <a href="{{ localized_route('submit.index') }}" class="text-accent hover:text-primary font-semibold">
                    {{ __('partners.contact') }}
                </a>
            </p>
        </div>
    </div>
</section>
