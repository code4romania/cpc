@php
    $supportPage = \App\Models\StaticPage::query()->published()->where('slug', 'home')->first();
@endphp
<x-ui.card data-support-lines class="p-8">
    <h2 class="text-2xl font-bold text-navy mb-5">{{ page_text($supportPage, 'support_title', 'support_lines.title') }}</h2>
    <ul class="grid grid-cols-[max-content_minmax(0,1fr)] items-baseline gap-x-6 gap-y-4">
        @foreach (['119', '116111', 'anitp', '112'] as $line)
            @php
                $number = page_text($supportPage, "support_{$line}_number", "support_lines.lines.$line.number");
            @endphp
            <li class="contents">
                <a href="tel:{{ str_replace(' ', '', $number) }}" class="text-lg font-bold text-primary hover:text-navy">
                    {{ $number }}
                </a>
                <div class="min-w-0">
                    <p class="font-semibold text-navy">{{ page_text($supportPage, "support_{$line}_name", "support_lines.lines.$line.name") }}</p>
                    <p class="text-sm text-muted">{{ page_text($supportPage, "support_{$line}_detail", "support_lines.lines.$line.detail") }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</x-ui.card>
