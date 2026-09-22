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

test('homepage statistics count up when scrolled into view', function () {
    $this->get('/ro')
        ->assertOk()
        ->assertSee('data-count-up="823"', false)
        ->assertSee('data-count-up="1247"', false)
        ->assertSee('data-count-up="78"', false)
        ->assertSee('data-count-up="89"', false)
        ->assertSee('IntersectionObserver', false);
});

test('homepage feature icons match the public design animation', function () {
    $this->get('/ro')
        ->assertOk()
        ->assertSee('data-feature-icon="book"', false)
        ->assertSee('data-feature-icon="download"', false)
        ->assertSee('data-feature-icon="building"', false)
        ->assertSee('data-feature-icon="chart"', false)
        ->assertSee('icon-book', false)
        ->assertSee('icon-arrow', false)
        ->assertSee('icon-building', false)
        ->assertSee('bar-1', false)
        ->assertSee('hover:scale-[1.06]', false)
        ->assertSee('group-hover:scale-110 group-hover:shadow-lg', false);
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

test('public navigation and homepage header use white text', function () {
    $response = $this->get('/ro');

    $response->assertOk();
    $response->assertSee('text-white hover:bg-primary/40', false);
    $response->assertSee('text-xl md:text-2xl mb-8 text-white', false);
    $response->assertSee('!text-navy', false);
    $response->assertDontSee('text-xl md:text-2xl mb-8 text-muted', false);
});
