<?php

use App\Models\StaticPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Legal')] class extends Component
{
    public string $slug;

    public ?StaticPage $page = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->page = StaticPage::published()->where('slug', $slug)->first();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="$page?->title ?? __('general.'.$slug)" />
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <x-ui.card class="p-8 md:p-12">
            @if ($page)
                <div class="prose prose-slate max-w-none text-navy">{!! $page->body !!}</div>
            @else
                <p class="text-muted">{{ __('general.legal_content_pending') }}</p>
            @endif
        </x-ui.card>
    </main>
</div>
