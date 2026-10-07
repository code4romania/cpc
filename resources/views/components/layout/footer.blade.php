<footer class="bg-navy text-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/brand/logo.png') }}" alt="" class="h-10 w-10 rounded-lg bg-white object-contain">
                    <div>
                        <div class="font-bold text-white">{{ __('footer.brand') }}</div>
                        <div class="text-xs text-muted">{{ __('footer.brand_sub') }}</div>
                    </div>
                </div>
                <p class="text-sm">{{ __('footer.tagline') }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-4">{{ __('footer.quicklinks') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ localized_route('home') }}" class="hover:text-white transition-colors">{{ __('nav.home') }}</a></li>
                    <li><a href="{{ localized_route('resources.index') }}" class="hover:text-white transition-colors">{{ __('nav.resources') }}</a></li>
                    <li><a href="{{ localized_route('organizations.index') }}" class="hover:text-white transition-colors">{{ __('nav.organizations') }}</a></li>
                    <li><a href="{{ localized_route('submit.index') }}" class="hover:text-white transition-colors">{{ __('nav.submit') }}</a></li>
                    <li><a href="{{ localized_route('about') }}" class="hover:text-white transition-colors">{{ __('nav.about') }}</a></li>
                    <li><a href="{{ localized_route('contact') }}" class="hover:text-white transition-colors">{{ __('contact.nav') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-4">{{ __('footer.legal') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ localized_route('terms') }}" class="hover:text-white transition-colors">{{ __('footer.terms') }}</a></li>
                    <li><a href="{{ localized_route('privacy') }}" class="hover:text-white transition-colors">{{ __('footer.privacy') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-primary pt-8 text-sm text-center">
            <p class="mb-2">{{ __('footer.emergency') }}</p>
            <p>&copy; {{ date('Y') }} {{ __('footer.copyright') }}</p>
        </div>
    </div>
</footer>
