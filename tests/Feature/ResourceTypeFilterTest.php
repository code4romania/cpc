<?php

use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Models\Resource;
use Livewire\Livewire;

test('resource type filter lists the public categories', function () {
    $this->get('/ro/resources')
        ->assertSuccessful()
        ->assertSee('Ghiduri și prezentări', false)
        ->assertSee('Documente', false)
        ->assertSee('Materiale video', false)
        ->assertSee('Printabile', false)
        ->assertSee('Materiale Online/Social-media', false);
});

test('resource type filter matches the selected label', function () {
    $video = Resource::factory()->create([
        'title_en' => 'Video type filter',
        'type' => ResourceType::Video,
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    $guide = Resource::factory()->create([
        'title_en' => 'Guide type filter',
        'type' => ResourceType::Guide,
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    Livewire::test('pages::resources-index')
        ->set('types', [ResourceType::Video->label()])
        ->assertSee($video->title_en)
        ->assertDontSee($guide->title_en);
});
