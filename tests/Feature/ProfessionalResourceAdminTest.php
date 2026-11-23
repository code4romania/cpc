<?php

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Filament\Resources\Professionals\Pages\CreateProfessional;
use App\Filament\Resources\Professionals\Pages\ListProfessionals;
use App\Models\ProfessionalResource;
use App\Models\ResourceCategory;
use App\Models\User;
use Livewire\Livewire;

test('professional resource form matches normal resources without public access', function () {
    expect(ResourceAccess::professionalOptions())->toBe([
        ResourceAccess::Ngo->value => __('enums.resource_access.ngo'),
        ResourceAccess::Mai->value => __('enums.resource_access.mai'),
    ])->and(ResourceAccess::professionalOptions())->not->toHaveKey(ResourceAccess::Public->value);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(CreateProfessional::class)
        ->assertFormFieldExists('slug')
        ->assertFormFieldExists('title_ro')
        ->assertFormFieldExists('description_ro')
        ->assertFormFieldExists('body_ro')
        ->assertFormFieldExists('title_en')
        ->assertFormFieldExists('description_en')
        ->assertFormFieldExists('body_en')
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('access_levels')
        ->assertFormFieldExists('resource_category_id')
        ->assertFormFieldExists('tags')
        ->assertFormFieldExists('author')
        ->assertFormFieldExists('download_url')
        ->assertFormFieldExists('video_url')
        ->assertFormFieldExists('file')
        ->assertFormFieldExists('featured')
        ->assertFormFieldExists('status')
        ->assertFormFieldExists('published_at');
});

test('admin can create a professional resource with the shared fields', function () {
    $admin = User::factory()->admin()->create();
    $category = ResourceCategory::factory()->create();

    $this->actingAs($admin);

    Livewire::test(CreateProfessional::class)
        ->fillForm([
            'slug' => 'trauma-interview-guide',
            'title_ro' => 'Ghid interviu',
            'title_en' => 'Interview guide',
            'description_ro' => 'Descriere scurtă',
            'description_en' => 'Short description',
            'body_ro' => 'Descriere lungă',
            'body_en' => 'Long description',
            'type' => ResourceType::Guide->value,
            'access_levels' => [ResourceAccess::Ngo->value],
            'resource_category_id' => $category->getKey(),
            'tags' => ['trauma', 'interview'],
            'author' => 'ANITP',
            'featured' => false,
            'status' => ResourceStatus::Published->value,
            'published_at' => now(),
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified();

    $resource = ProfessionalResource::query()->where('slug', 'trauma-interview-guide')->first();

    expect($resource)->not->toBeNull()
        ->and($resource->type)->toBe(ResourceType::Guide)
        ->and($resource->access_levels)->toBe([ResourceAccess::Ngo->value])
        ->and($resource->resource_category_id)->toBe($category->getKey())
        ->and($resource->status)->toBe(ResourceStatus::Published)
        ->and($resource->author)->toBe('ANITP');
});

test('professional resources table filters match normal resources without public access', function () {
    $admin = User::factory()->admin()->create();
    $category = ResourceCategory::factory()->create([
        'name_ro' => 'Filtru categorie profesională',
    ]);
    $matching = ProfessionalResource::factory()->create([
        'slug' => 'matching-professional-resource',
        'title_ro' => 'Resursa potrivită',
        'type' => ResourceType::Guide,
        'resource_category_id' => $category->getKey(),
        'access_levels' => [ResourceAccess::Ngo->value],
        'status' => ResourceStatus::Published,
    ]);
    $other = ProfessionalResource::factory()->create([
        'slug' => 'other-professional-resource',
        'title_ro' => 'Altă resursă',
        'type' => ResourceType::Video,
        'access_levels' => [ResourceAccess::Mai->value],
        'status' => ResourceStatus::Draft,
    ]);

    $this->actingAs($admin);

    Livewire::test(ListProfessionals::class)
        ->assertCanSeeTableRecords([$matching, $other])
        ->filterTable('type', ResourceType::Guide->value)
        ->assertCanSeeTableRecords([$matching])
        ->assertCanNotSeeTableRecords([$other])
        ->filterTable('type')
        ->filterTable('access_levels', ResourceAccess::Ngo->value)
        ->assertCanSeeTableRecords([$matching])
        ->assertCanNotSeeTableRecords([$other]);
});
