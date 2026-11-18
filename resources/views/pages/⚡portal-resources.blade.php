<?php

use App\Models\ProfessionalResource;
use App\Models\ResourceCategory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Professional Resources')] class extends Component
{
    public string $search = '';

    public string $category = '';

    /** @return Collection<int, ProfessionalResource> */
    public function resources(): Collection
    {
        return ProfessionalResource::published()
            ->with('resourceCategory')
            ->when($this->search, fn ($query) => $query->where(function ($query): void {
                $query->where('title_ro', 'like', '%'.$this->search.'%')
                    ->orWhere('title_en', 'like', '%'.$this->search.'%')
                    ->orWhere('description_ro', 'like', '%'.$this->search.'%')
                    ->orWhere('description_en', 'like', '%'.$this->search.'%')
                    ->orWhere('author', 'like', '%'.$this->search.'%');
            }))
            ->when($this->category, fn ($query) => $query->where('resource_category_id', $this->category))
            ->latest('published_at')
            ->get();
    }

    /** @return Collection<int, ResourceCategory> */
    public function categories(): Collection
    {
        return ResourceCategory::query()
            ->whereHas('professionalResources', fn ($query) => $query->published())
            ->orderBy('name_ro')
            ->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('portal.resources')" :subtitle="__('portal.resources_body')" />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="bg-white border border-[color:var(--color-border)] rounded-xl p-6 grid md:grid-cols-2 gap-5 mb-8">
            <x-ui.input wire:model.live.debounce.300ms="search" :label="__('portal.search')" />
            <x-ui.select wire:model.live="category" :label="__('portal.category')">
                <option value="">{{ __('portal.all_categories') }}</option>
                @foreach ($this->categories() as $option)
                    <option value="{{ $option->getKey() }}">{{ $option->name }}</option>
                @endforeach
            </x-ui.select>
        </section>
        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($this->resources() as $resource)
                <x-ui.card wire:key="professional-resource-{{ $resource->id }}" class="p-6">
                    <h2 class="text-xl font-semibold text-navy">{{ $resource->title }}</h2>
                    <p class="text-muted mt-2">{{ $resource->description }}</p>
                    <div class="flex flex-wrap gap-2 mt-4">
                        @if ($resource->resourceCategory)
                            <x-ui.badge variant="accent">{{ $resource->resourceCategory->name }}</x-ui.badge>
                        @endif
                        <x-ui.badge>{{ $resource->type->label() }}</x-ui.badge>
                    </div>
                    @if ($resource->file_url)
                        <x-ui.button class="mt-5" href="{{ $resource->file_url }}" target="_blank">{{ __('portal.download') }}</x-ui.button>
                    @elseif ($resource->download_url)
                        <x-ui.button class="mt-5" href="{{ $resource->download_url }}" target="_blank">{{ __('portal.download') }}</x-ui.button>
                    @endif
                </x-ui.card>
            @empty
                <x-ui.card class="md:col-span-2 p-12 text-center text-muted">{{ __('portal.no_resources') }}</x-ui.card>
            @endforelse
        </div>
    </main>
</div>
