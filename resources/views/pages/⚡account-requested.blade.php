<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.auth')] #[Title('Account requested')] class extends Component {};
?>

<div class="max-w-xl w-full">
    <x-ui.card class="p-8 text-center">
        <h1 class="text-2xl font-bold text-navy mb-3">{{ __('auth.request_sent_title') }}</h1>
        <p class="text-navy leading-7">{{ __('auth.request_sent_body') }}</p>
        <x-ui.button href="{{ localized_route('home') }}" class="mt-6">{{ __('auth.back_home') }}</x-ui.button>
    </x-ui.card>
</div>
