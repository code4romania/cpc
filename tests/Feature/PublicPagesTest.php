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

it('renders public data detail pages', function () {
    $resource = Resource::factory()->create([
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);
    $dataset = StatisticDataset::factory()->create();

    $this->get('/ro/resources/' . $resource->slug)->assertSuccessful();
    $this->get('/ro/statistics/' . $dataset->slug)->assertSuccessful();
    $this->get('/ro/statistics/index-vulnerability')->assertSuccessful();
    $this->get('/ro/partner-organizations')->assertSuccessful();
    $this->get('/ro/submit')->assertSuccessful();
});
