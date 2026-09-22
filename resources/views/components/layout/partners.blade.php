<section class="bg-white border-t border-[color:var(--color-border)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-navy mb-2">{{ __('partners.title') }}</h2>
            <p class="text-muted">{{ __('partners.subtitle') }}</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-8 items-center">
            @foreach ([
                ['name' => 'eLiberare', 'url' => 'https://www.eliberare.com', 'logo' => 'images/partners/eliberare.svg'],
                ['name' => 'FONPC', 'url' => 'https://www.fonpc.ro', 'logo' => 'images/partners/fonpc.svg'],
                ['name' => 'Code for Romania', 'url' => 'https://code4.ro', 'logo' => 'images/partners/code4ro.svg'],
                ['name' => 'Terre des Hommes', 'url' => 'https://www.tdh.ro', 'logo' => 'images/partners/tdh.svg'],
                ['name' => 'Guvernul României', 'url' => 'https://gov.ro', 'logo' => 'images/partners/gov.svg'],
                ['name' => 'US State Dept', 'url' => 'https://www.state.gov', 'logo' => 'images/partners/state.svg'],
                ['name' => 'World Vision', 'url' => 'https://worldvision.ro', 'logo' => 'images/partners/worldvision.svg'],
            ] as $partner)
                <a href="{{ $partner['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center p-4 grayscale hover:grayscale-0 transition-all duration-300 opacity-70 hover:opacity-100">
                    <img src="{{ asset($partner['logo']) }}" alt="{{ $partner['name'] }}" class="w-full h-16 object-contain">
                </a>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <p class="text-sm text-muted">
                {{ __('partners.cta') }}
                <a href="{{ localized_route('contact') }}" class="text-accent hover:text-primary font-semibold">
                    {{ __('partners.contact') }}
                </a>
            </p>
        </div>
    </div>
</section>
