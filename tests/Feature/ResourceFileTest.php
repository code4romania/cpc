<?php

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Models\Resource;
use Illuminate\Http\UploadedFile;

test('the public resource page links to the uploaded file', function () {
    $resource = Resource::factory()->create([
        'slug' => 'with-a-file',
        'title_en' => 'Resource with a file',
        'status' => ResourceStatus::Published,
        'published_at' => now(),
        'access_levels' => [ResourceAccess::Public->value],
    ]);

    $resource->addMedia(UploadedFile::fake()->create('guide.pdf', 20, 'application/pdf'))
        ->toMediaCollection('file');

    $path = parse_url((string) $resource->fresh()->file_url, PHP_URL_PATH);

    expect($path)->not->toBeNull();

    $this->get('/en/resources/with-a-file')
        ->assertSuccessful()
        ->assertSee('guide.pdf', false)
        ->assertSee($path, false);
});
