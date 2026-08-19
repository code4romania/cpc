<?php

use App\Enums\ResourceStatus;
use App\Enums\SubmissionStatus;
use App\Filament\Resources\Resources\Pages\ListResources;
use App\Filament\Resources\ResourceSubmissions\Pages\ListResourceSubmissions;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use App\Models\User;
use Livewire\Livewire;

test('admin can list resources', function () {
    $admin = User::factory()->admin()->create();
    $resources = Resource::factory()
        ->count(3)
        ->sequence(
            ['slug' => 'filament-list-test-1'],
            ['slug' => 'filament-list-test-2'],
            ['slug' => 'filament-list-test-3'],
        )
        ->create();

    $this->actingAs($admin);

    Livewire::test(ListResources::class)
        ->searchTable('filament-list-test')
        ->assertCanSeeTableRecords($resources);
});

test('admin can approve a resource submission', function () {
    $admin = User::factory()->admin()->create();
    $category = ResourceCategory::factory()->create([
        'slug' => 'legal-guides',
        'name_ro' => 'Legal Guides',
        'name_en' => 'Legal Guides',
    ]);
    $submission = ResourceSubmission::factory()->create([
        'title' => 'Know Your Rights',
        'category' => 'Legal Guides',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListResourceSubmissions::class)
        ->callTableAction('approve', $submission)
        ->assertNotified();

    $submission->refresh();
    $resource = $submission->resource;

    expect($submission->status)->toBe(SubmissionStatus::Approved)
        ->and($submission->reviewed_by)->toBe($admin->getKey())
        ->and($submission->reviewed_at)->not->toBeNull()
        ->and($resource)->not->toBeNull()
        ->and($resource->resource_category_id)->toBe($category->getKey())
        ->and($resource->status)->toBe(ResourceStatus::Published)
        ->and($resource->published_at)->not->toBeNull();
});
