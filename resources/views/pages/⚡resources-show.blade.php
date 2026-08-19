<?php

use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Resource')] class extends Component
{
    public Resource $resource;

    public function mount(string $slug): void
    {
        $this->resource = Resource::published()
            ->with('resourceCategory')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /** @return Collection<int, Resource> */
    public function relatedResources(): Collection
    {
        return Resource::published()
            ->whereKeyNot($this->resource->getKey())
            ->where('resource_category_id', $this->resource->resource_category_id)
            ->limit(3)
            ->get();
    }
};
?>

<div class="min-h-screen bg-background">
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ localized_route('resources.index') }}" class="inline-flex text-primary hover:text-navy mb-6">← {{ __('resources.back') }}</a>

        <article class="bg-white rounded-xl border border-[color:var(--color-border)] overflow-hidden">
            <header class="p-8 border-b border-[color:var(--color-border)]">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <x-ui.badge variant="accent">{{ $resource->type->label() }}</x-ui.badge>
                    @if ($resource->featured)
                        <x-ui.badge variant="featured">{{ __('card.featured') }}</x-ui.badge>
                    @endif
                </div>
                <h1 class="text-3xl font-bold text-navy mb-4">{{ $resource->title }}</h1>
                <div class="flex flex-wrap gap-4 text-sm text-muted mb-5">
                    <span>{{ $resource->resourceCategory?->name }}</span>
                    <span>{{ __('card.author') }}: {{ $resource->author }}</span>
                    <span>{{ $resource->published_at?->translatedFormat('j F Y') }}</span>
                </div>
                <p class="text-lg text-navy">{{ $resource->description }}</p>
                <div class="flex flex-wrap gap-3 mt-6">
                    @if ($resource->download_url)
                        <x-ui.button href="{{ $resource->download_url }}" target="_blank">{{ __('resources.download') }}</x-ui.button>
                    @endif
                    @if ($resource->video_url)
                        <x-ui.button href="{{ $resource->video_url }}" target="_blank" variant="accent">{{ __('resources.watch') }}</x-ui.button>
                    @endif
                </div>
            </header>
            <div class="p-8">
                <h2 class="text-xl font-semibold text-navy mb-4">{{ __('resources.about') }}</h2>
                <p class="text-muted leading-7">{{ $resource->description }}</p>
                @if ($resource->tags)
                    <div class="flex flex-wrap gap-2 mt-8">
                        @foreach ($resource->tags as $tag)
                            <x-ui.badge wire:key="tag-{{ md5($tag) }}" variant="accent">{{ $tag }}</x-ui.badge>
                        @endforeach
                    </div>
                @endif
            </div>
        </article>

        @if ($this->relatedResources()->isNotEmpty())
            <section class="mt-12">
                <h2 class="text-2xl font-bold text-navy mb-6">{{ __('resources.related') }}</h2>
                <div class="grid md:grid-cols-3 gap-5">
                    @foreach ($this->relatedResources() as $related)
                        <a wire:key="related-{{ $related->id }}" href="{{ localized_route('resources.show', ['slug' => $related->slug]) }}"
                           class="bg-white border border-[color:var(--color-border)] rounded-lg p-5 hover:border-accent">
                            <h3 class="font-semibold text-navy">{{ $related->title }}</h3>
                            <p class="text-sm text-muted mt-2 line-clamp-3">{{ $related->description }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</div>
