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

<div class="space-y-2" x-data="{ open: false }" @keydown.escape.window="open = false">
    <label class="block text-sm font-medium text-navy">{{ $label }}</label>

    <div class="relative">
        <button type="button"
                @click="open = !open"
                :class="open ? 'border-accent ring-2 ring-accent/30' : 'border-[color:var(--color-border)] hover:border-accent'"
                class="w-full flex items-center justify-between rounded-lg border bg-white px-4 py-2.5 text-left text-navy focus:border-accent focus:ring-2 focus:ring-accent/30 focus:outline-none">
            <span class="truncate text-sm {{ count($selected) ? 'text-navy' : 'text-muted' }}">
                @if (count($selected) === 0)
                    {{ $placeholder }}
                @elseif (count($selected) === 1)
                    {{ $selected[0] }}
                @else
                    {{ count($selected) }} {{ __('filters.selected') }}
                @endif
            </span>
            <svg class="w-4 h-4 shrink-0 text-muted transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="open"
             x-cloak
             @click.outside="open = false"
             class="absolute top-full left-0 z-30 mt-1 w-full overflow-hidden rounded-lg border border-[color:var(--color-border)] bg-white shadow-xl">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-[color:var(--color-border)] bg-white px-3 py-2">
                <button type="button" wire:click="selectAll" class="text-xs font-medium text-primary hover:text-navy">{{ __('filters.select_all') }}</button>
                <button type="button" wire:click="clear" class="text-xs font-medium text-muted hover:text-navy">{{ __('filters.clear') }}</button>
            </div>
            <div class="max-h-64 overflow-y-auto p-1">
                @forelse ($options as $option)
                    <label wire:key="option-{{ md5($option) }}" class="flex cursor-pointer items-center gap-3 rounded px-2 py-2.5 text-sm text-navy hover:bg-surface-muted">
                        <input type="checkbox" value="{{ $option }}" wire:model.live="selected" class="h-4 w-4 shrink-0 rounded border-[color:var(--color-border)] text-accent focus:ring-accent">
                        <span class="leading-tight">{{ $option }}</span>
                    </label>
                @empty
                    <p class="px-3 py-2 text-sm text-muted">{{ __('filters.no_options') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
