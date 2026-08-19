<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public string $pageTitle = '';

    public function mount(string $pageTitle = ''): void
    {
        $this->pageTitle = $pageTitle;
    }
};
?>

<div class="min-h-[50vh] flex items-center justify-center bg-background">
    <div class="text-center px-4">
        <h1 class="text-3xl font-bold text-navy mb-4">{{ $pageTitle }}</h1>
        <p class="text-muted mb-6">{{ __('general.coming_soon') }}</p>
        <a href="{{ localized_route('home') }}" class="text-accent hover:text-primary font-semibold">{{ __('general.back_home') }}</a>
    </div>
</div>
