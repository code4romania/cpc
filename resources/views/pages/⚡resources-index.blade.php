<?php

use App\Enums\ResourceType;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app')] #[Title('Resources')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public array $categories = [];

    public array $types = [];

    public array $authors = [];

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'categories', 'types', 'authors'], true)) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'categories', 'types', 'authors']);
        $this->resetPage();
    }

    /** @return array<int, string> */
    public function categoryOptions(): array
    {
        return ResourceCategory::query()->orderBy('sort_order')->get()->pluck('name')->filter()->values()->all();
    }

    /** @return array<int, string> */
    public function typeOptions(): array
    {
        return collect(ResourceType::cases())->map(fn (ResourceType $type): string => $type->value)->all();
    }

    /** @return array<int, string> */
    public function authorOptions(): array
    {
        return Resource::published()->whereNotNull('author')->distinct()->orderBy('author')->pluck('author')->all();
    }

    public function resources(): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Resource::published()
            ->with('resourceCategory')
            ->when($this->search, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('title_ro', 'like', '%'.$this->search.'%')
                        ->orWhere('title_en', 'like', '%'.$this->search.'%')
                        ->orWhere('description_ro', 'like', '%'.$this->search.'%')
                        ->orWhere('description_en', 'like', '%'.$this->search.'%')
                        ->orWhere('author', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->categories, fn ($query) => $query->whereHas(
                'resourceCategory',
                fn ($query) => $query->whereIn('name_'.$locale, $this->categories),
            ))
            ->when($this->types, fn ($query) => $query->whereIn('type', $this->types))
            ->when($this->authors, fn ($query) => $query->whereIn('author', $this->authors))
            ->latest('published_at')
            ->paginate(12);
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('resources.title')" :subtitle="__('resources.subtitle')" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="bg-white rounded-xl border border-[color:var(--color-border)] p-6 mb-8">
            <label for="resource-search" class="block text-sm font-medium text-navy mb-2">{{ __('resources.search_label') }}</label>
            <input id="resource-search" type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('resources.search_placeholder') }}"
                   class="w-full rounded-lg border border-[color:var(--color-border)] px-4 py-3 focus:border-accent focus:ring-accent">

            <div class="grid md:grid-cols-3 gap-6 mt-6">
                <livewire:multi-select-filter wire:model.live="categories" :options="$this->categoryOptions()" :label="__('resources.category')" :placeholder="__('resources.all_categories')" />
                <livewire:multi-select-filter wire:model.live="types" :options="$this->typeOptions()" :label="__('resources.type')" :placeholder="__('resources.all_types')" />
                <livewire:multi-select-filter wire:model.live="authors" :options="$this->authorOptions()" :label="__('resources.author')" :placeholder="__('resources.all_authors')" />
            </div>

            @if ($search !== '' || $categories || $types || $authors)
                <button type="button" wire:click="clearFilters" class="mt-5 text-sm font-semibold text-primary hover:text-navy">
                    {{ __('resources.clear_all') }}
                </button>
            @endif
        </section>

        @php($resources = $this->resources())
        <p class="text-muted mb-6">{{ __('resources.showing', ['count' => $resources->total()]) }}</p>

        @if ($resources->isNotEmpty())
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($resources as $resource)
                    <x-resource-card
                        wire:key="resource-{{ $resource->id }}"
                        :title="$resource->title"
                        :description="$resource->description"
                        :author="$resource->author"
                        :type="$resource->type->value"
                        :tags="$resource->tags ?? []"
                        :featured="$resource->featured"
                        :url="localized_route('resources.show', ['slug' => $resource->slug])"
                    />
                @endforeach
            </div>
            <div class="mt-8">{{ $resources->links() }}</div>
        @else
            <x-ui.card class="p-12 text-center">
                <h2 class="text-xl font-semibold text-navy">{{ __('resources.none') }}</h2>
                <button wire:click="clearFilters" class="mt-4 text-primary font-semibold">{{ __('resources.reset') }}</button>
            </x-ui.card>
        @endif
    </main>
</div>
