<?php

use Livewire\Attributes\Modelable;
use Livewire\Component;

new class extends Component
{
    #[Modelable]
    public array $selected = [];

    /** @var array<int, string> */
    public array $options = [];

    public string $label = '';

    public string $placeholder = '';

    public function selectAll(): void
    {
        $this->selected = array_values($this->options);
    }

    public function clear(): void
    {
        $this->selected = [];
    }
};
?>

<div class="space-y-2" x-data="{ open: false }">
    <label class="block text-sm font-medium text-navy">{{ $label }}</label>
    <button type="button"
            @click="open = !open"
            class="w-full flex items-center justify-between rounded-lg border border-[color:var(--color-border)] bg-surface-muted px-4 py-2.5 text-left text-navy focus:border-accent focus:ring-2 focus:ring-accent/30 focus:outline-none">
        <span class="text-sm {{ count($selected) ? 'text-navy' : 'text-muted' }}">
            @if (count($selected) === 0)
                {{ $placeholder }}
            @else
                {{ count($selected) }} {{ __('filters.selected') }}
            @endif
        </span>
        <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>

    <div x-show="open" x-cloak @click.outside="open = false" class="rounded-lg border border-[color:var(--color-border)] bg-white shadow-lg p-3 space-y-2">
        <div class="flex gap-2 pb-2 border-b border-[color:var(--color-border)]">
            <button type="button" wire:click="selectAll" class="text-xs font-medium text-primary hover:text-navy">{{ __('filters.select_all') }}</button>
            <button type="button" wire:click="clear" class="text-xs font-medium text-muted hover:text-navy">{{ __('filters.clear') }}</button>
        </div>
        @forelse ($options as $option)
            <label wire:key="option-{{ md5($option) }}" class="flex items-center gap-2 text-sm text-navy cursor-pointer hover:bg-surface-muted rounded px-2 py-1">
                <input type="checkbox" value="{{ $option }}" wire:model.live="selected" class="rounded border-[color:var(--color-border)] text-accent focus:ring-accent">
                <span>{{ $option }}</span>
            </label>
        @empty
            <p class="text-sm text-muted px-2">{{ __('filters.no_options') }}</p>
        @endforelse
    </div>
</div>
