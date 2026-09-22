<?php

use App\Enums\ResourceStatus;
use App\Models\Resource;
use App\Models\StatisticDataset;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders public pages', function (string $path) {
    $this->get($path)->assertSuccessful();
})->with([
    '/ro/resources',
    '/en/about',
    '/ro/organizations',
    '/ro/statistics',
    '/ro/terms',
]);

it('shows the resource language and the type of related resources', function () {
    $resource = Resource::factory()->create([
        'title_ro' => 'Resursă principală',
        'title_en' => 'Primary resource',
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    $related = Resource::factory()->create([
        'title_ro' => 'Resursă conexă',
        'resource_category_id' => $resource->resource_category_id,
        'type' => $resource->type,
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    $this->get('/ro/resources/'.$resource->slug)
        ->assertSuccessful()
        ->assertSee('RO', false)
        ->assertSee('EN', false)
        ->assertSee($related->type->label(), false)
        ->assertSee('Resursă conexă', false);
});

it('renders public data detail pages', function () {
    $resource = Resource::factory()->create([
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);
    $dataset = StatisticDataset::factory()->create();

    $this->get('/ro/resources/'.$resource->slug)->assertSuccessful();
    $this->get('/ro/statistics/'.$dataset->slug)->assertSuccessful();
    $this->get('/ro/statistics/index-vulnerability')->assertSuccessful();
    $this->get('/ro/partner-organizations')->assertSuccessful();
    $this->get('/ro/submit')->assertSuccessful();
});
