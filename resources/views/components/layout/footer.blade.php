<footer class="bg-navy text-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-accent p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
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
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-4">{{ __('footer.legal') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ localized_route('terms') }}" class="hover:text-white transition-colors">{{ __('footer.terms') }}</a></li>
                    <li><a href="{{ localized_route('cookie-policy') }}" class="hover:text-white transition-colors">{{ __('footer.cookie') }}</a></li>
                    <li><a href="{{ localized_route('privacy') }}" class="hover:text-white transition-colors">{{ __('footer.privacy') }}</a></li>
                    <li><a href="{{ localized_route('accessibility') }}" class="hover:text-white transition-colors">{{ __('footer.accessibility') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-primary pt-8 text-sm text-center">
            <p class="mb-2">{{ __('footer.emergency') }}</p>
            <p>&copy; {{ date('Y') }} {{ __('footer.copyright') }}</p>
        </div>
    </div>
</footer>
