<?php

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Models\Resource;

test('the public detail page shows the long description and the catalogue keeps the short one', function () {
    Resource::factory()->create([
        'slug' => 'long-description',
        'title_en' => 'Resource with a long description',
        'description_en' => 'Short card summary',
        'body_en' => '<p>This longer text appears only on the detail page.</p>',
        'status' => ResourceStatus::Published,
        'published_at' => now(),
        'access_levels' => [ResourceAccess::Public->value],
    ]);

    $this->get('/en/resources')
        ->assertSuccessful()
        ->assertSee('Short card summary', false)
        ->assertDontSee('This longer text appears only on the detail page', false);

    $this->get('/en/resources/long-description')
        ->assertSuccessful()
        ->assertSee('Short card summary', false)
        ->assertSee('This longer text appears only on the detail page', false);
});
