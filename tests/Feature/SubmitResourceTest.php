<?php

use App\Models\County;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('allows a visitor to submit a resource', function () {
    Storage::fake('local');

    $county = County::factory()->create([
        'name_ro' => 'Cluj',
        'name_en' => 'Cluj',
    ]);
    $category = ResourceCategory::factory()->create([
        'name_ro' => 'Prevenire și educație',
        'name_en' => 'Prevention and education',
    ]);

    Livewire::test('pages::submit')
        ->set('title', 'Professional safety guide')
        ->set('description', 'A practical guide for child protection teams.')
        ->set('type', 'guide')
        ->set('category', $category->name_en)
        ->set('language', 'en')
        ->set('createdOn', '2026-03-01')
        ->set('targetAudience', 'Social workers')
        ->set('tags', 'safety, reporting')
        ->set('submitterName', 'Ana Pop')
        ->set('submitterEmail', 'ana@example.com')
        ->set('submitterOrganization', 'Example NGO')
        ->set('organizationWebsite', 'https://example.org')
        ->set('counties', [$county->name_ro])
        ->set('files', [UploadedFile::fake()->create('guide.pdf', 100, 'application/pdf')])
        ->set('rightsConfirmed', true)
        ->set('reviewConfirmed', true)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $submission = ResourceSubmission::query()->where('submitter_email', 'ana@example.com')->first();

    expect($submission)->not->toBeNull()
        ->and($submission->counties)->toBe(['Cluj'])
        ->and($submission->tags)->toBe(['safety', 'reporting'])
        ->and($submission->file_paths)->toHaveCount(1);

    Storage::disk('local')->assertExists($submission->file_paths[0]);
});

it('shows the submission guidelines', function () {
    $this->get('/ro/submit')
        ->assertSuccessful()
        ->assertSee('interpretare în limbaj semne', false)
        ->assertSee('Materiale Online/Social-media', false);
});
