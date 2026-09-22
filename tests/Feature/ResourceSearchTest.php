<?php

use App\Enums\ResourceStatus;
use App\Models\Resource;
use Livewire\Livewire;

test('resource search matches tags', function () {
    $matching = Resource::factory()->create([
        'title_ro' => 'Ghid de semnalare',
        'title_en' => 'Reporting guide',
        'description_ro' => 'Descriere',
        'description_en' => 'Description',
        'author' => 'ANITP',
        'tags' => ['trafic', 'semne de risc'],
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    $other = Resource::factory()->create([
        'title_ro' => 'Alt material',
        'title_en' => 'Other material',
        'description_ro' => 'Altceva',
        'description_en' => 'Something else',
        'author' => 'ANITP',
        'tags' => ['legislatie'],
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    Livewire::test('pages::resources-index')
        ->set('search', 'semne de risc')
        ->assertSee($matching->title_en)
        ->assertDontSee($other->title_en);

    $this->get('/ro/resources')
        ->assertOk()
        ->assertSee(__('resources.search_placeholder', [], 'ro'), false);
});
