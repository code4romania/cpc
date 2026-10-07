<x-ui.card data-support-lines class="p-8">
    <h2 class="text-2xl font-bold text-navy mb-5">{{ __('support_lines.title') }}</h2>
    <ul class="space-y-4">
        @foreach (['119', '116111', 'anitp', '112'] as $line)
            <li class="flex flex-col gap-1 sm:flex-row sm:items-baseline sm:gap-4">
                <a href="tel:{{ str_replace(' ', '', __('support_lines.lines.'.$line.'.number')) }}" class="text-lg font-bold text-primary hover:text-navy shrink-0">
                    {{ __('support_lines.lines.'.$line.'.number') }}
                </a>
                <div>
                    <p class="font-semibold text-navy">{{ __('support_lines.lines.'.$line.'.name') }}</p>
                    <p class="text-sm text-muted">{{ __('support_lines.lines.'.$line.'.detail') }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</x-ui.card>
