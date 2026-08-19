<div id="cookie-consent"
     x-data="{ visible: !localStorage.getItem('cookie_consent') }"
     x-show="visible"
     x-cloak
     class="fixed bottom-0 inset-x-0 z-50 p-4">
    <div class="max-w-4xl mx-auto bg-navy text-white rounded-lg shadow-lg border border-primary p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
        <p class="text-sm text-muted flex-1">
            {{ __('cookie.message') }}
            <a href="{{ localized_route('cookie-policy') }}" class="text-white underline hover:text-accent">{{ __('cookie.policy_link') }}</a>.
        </p>
        <div class="flex gap-3 shrink-0">
            <button type="button"
                    @click="localStorage.setItem('cookie_consent', 'declined'); visible = false"
                    class="px-4 py-2 text-sm font-medium rounded-lg border border-primary text-muted hover:text-white transition-colors">
                {{ __('cookie.decline') }}
            </button>
            <button type="button"
                    @click="localStorage.setItem('cookie_consent', 'accepted'); visible = false"
                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-primary text-white hover:bg-accent transition-colors">
                {{ __('cookie.accept') }}
            </button>
        </div>
    </div>
</div>
