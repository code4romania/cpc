@php
    $locale = app()->getLocale();
    $navLinks = [
        ['route' => 'home', 'label' => __('nav.home')],
        ['route' => 'resources.index', 'label' => __('nav.resources')],
        ['route' => 'statistics.index', 'label' => __('nav.statistics')],
        ['route' => 'organizations.index', 'label' => __('nav.organizations')],
        ['route' => 'submit.index', 'label' => __('nav.submit')],
        ['route' => 'about', 'label' => __('nav.about')],
    ];
@endphp

<header class="bg-navy border-b border-primary sticky top-0 z-50" x-data="{ mobileOpen: false, langOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ localized_route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div class="flex items-center gap-2">
                    <div class="bg-accent p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-white text-sm leading-tight">{{ __('footer.brand') }}</div>
                        <div class="text-xs text-muted">{{ __('footer.brand_sub') }}</div>
                    </div>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-6">
                <nav class="flex items-center space-x-2" aria-label="Main">
                    @foreach ($navLinks as $link)
                        <a href="{{ localized_route($link['route']) }}"
                           @class([
                               'block px-3 py-2 rounded-lg font-medium transition-colors',
                               'text-white bg-primary/60' => request()->routeIs($link['route']),
                               'text-muted hover:text-white hover:bg-primary/40' => ! request()->routeIs($link['route']),
                           ])>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                @auth
                    @if (auth()->user()->isVerifiedProfessional())
                        <a href="{{ localized_route('portal.index') }}"
                           @class([
                               'px-3 py-2 rounded-lg font-medium transition-colors',
                               'text-white bg-primary/60' => request()->routeIs('portal.*'),
                               'text-muted hover:text-white hover:bg-primary/40' => ! request()->routeIs('portal.*'),
                           ])>
                            {{ __('auth.portal_nav') }}
                        </a>
                    @elseif (auth()->user()->isProfessional())
                        <a href="{{ localized_route('auth.pending') }}" class="px-3 py-2 rounded-lg font-medium text-muted hover:text-white hover:bg-primary/40">
                            {{ __('auth.pending_title') }}
                        </a>
                    @endif

                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg font-medium text-muted hover:text-white hover:bg-primary/40">
                            {{ __('auth.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ localized_route('login') }}"
                       @class([
                           'px-3 py-2 rounded-lg font-medium transition-colors',
                           'text-white bg-primary/60' => request()->routeIs('login'),
                           'text-muted hover:text-white hover:bg-primary/40' => ! request()->routeIs('login'),
                       ])>
                        {{ __('auth.login_nav') }}
                    </a>
                @endauth

                <livewire:language-switcher />
            </div>

            <button type="button"
                    class="md:hidden p-2 rounded-lg hover:bg-primary/40 text-white"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen"
                    aria-label="{{ __('nav.menu_toggle') }}">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav x-show="mobileOpen" x-cloak class="md:hidden py-4 border-t border-primary" aria-label="Mobile">
            @foreach ($navLinks as $link)
                <a href="{{ localized_route($link['route']) }}"
                   @class([
                       'block py-2 px-4 text-sm font-medium rounded-lg mb-1',
                       'text-white bg-primary' => request()->routeIs($link['route']),
                       'text-muted hover:bg-primary/40 hover:text-white' => ! request()->routeIs($link['route']),
                   ])
                   @click="mobileOpen = false">
                    {{ $link['label'] }}
                </a>
            @endforeach

            @auth
                @if (auth()->user()->isVerifiedProfessional())
                    <a href="{{ localized_route('portal.index') }}" class="block py-2 px-4 text-sm font-medium rounded-lg mb-1 text-muted hover:bg-primary/40 hover:text-white" @click="mobileOpen = false">
                        {{ __('auth.portal_nav') }}
                    </a>
                @elseif (auth()->user()->isProfessional())
                    <a href="{{ localized_route('auth.pending') }}" class="block py-2 px-4 text-sm font-medium rounded-lg mb-1 text-muted hover:bg-primary/40 hover:text-white" @click="mobileOpen = false">
                        {{ __('auth.pending_title') }}
                    </a>
                @endif
                <form method="POST" action="{{ url('/logout') }}" class="px-4">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-sm font-medium text-muted hover:text-white">
                        {{ __('auth.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ localized_route('login') }}" class="block py-2 px-4 text-sm font-medium rounded-lg mb-1 text-muted hover:bg-primary/40 hover:text-white" @click="mobileOpen = false">
                    {{ __('auth.login_nav') }}
                </a>
            @endauth

            <div class="mt-4 pt-4 border-t border-primary px-4">
                <p class="text-xs text-muted mb-2">{{ __('nav.language') }}</p>
                <livewire:language-switcher :mobile="true" />
            </div>
        </nav>
    </div>
</header>
