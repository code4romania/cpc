<?php

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Models\Resource;

test('a resource marked published is public even when the publish date was left empty', function () {
    $resource = Resource::factory()->create([
        'title_en' => 'Published without a date',
        'title_ro' => 'Publicat fără dată',
        'slug' => 'published-without-a-date',
        'status' => ResourceStatus::Published,
        'published_at' => null,
        'access_levels' => [ResourceAccess::Public->value],
    ]);

    expect($resource->fresh()->published_at)->not->toBeNull();

    $this->get('/en/resources')
        ->assertSuccessful()
        ->assertSee('Published without a date', false);

    $this->get('/en/resources/published-without-a-date')
        ->assertSuccessful()
        ->assertSee('Published without a date', false);
});

test('a draft resource stays unpublished when it has no publish date', function () {
    $resource = Resource::factory()->create([
        'title_en' => 'Still a draft',
        'slug' => 'still-a-draft',
        'status' => ResourceStatus::Draft,
        'published_at' => null,
        'access_levels' => [ResourceAccess::Public->value],
    ]);

    expect($resource->fresh()->published_at)->toBeNull();

    $this->get('/en/resources')->assertDontSee('Still a draft', false);
});
