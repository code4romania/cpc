<?php

use App\Enums\ResourceStatus;
use App\Models\Resource;

test('home page renders in romanian', function () {
    $response = $this->get('/ro');

    $response->assertOk();
    $response->assertSee(__('home.hero_title', [], 'ro'), false);
});

test('home page renders in english', function () {
    $response = $this->get('/en');

    $response->assertOk();
    $response->assertSee(__('home.hero_title', [], 'en'), false);
});

test('homepage shows at most six featured resources', function () {
    $resources = Resource::factory()
        ->count(7)
        ->sequence(fn ($sequence): array => [
            'title_ro' => 'Featured resource '.$sequence->index,
            'title_en' => 'Featured resource '.$sequence->index,
            'published_at' => now()->subDays($sequence->index),
        ])
        ->create([
            'featured' => true,
            'status' => ResourceStatus::Published,
        ]);

    $response = $this->get('/ro')->assertOk();

    foreach ($resources->take(6) as $resource) {
        $response->assertSee($resource->title_ro, false);
    }

    $response->assertDontSee($resources->last()->title_ro, false);
});
