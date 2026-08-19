<?php

use App\Enums\ChartType;
use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use App\Enums\IndexType;
use App\Enums\OrganizationType;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\County;
use App\Models\IndexCountyScore;
use App\Models\Organization;
use App\Models\PartnerOrganization;
use App\Models\ProfessionalResource;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use App\Models\StaticPage;
use App\Models\StatisticDataPoint;
use App\Models\StatisticDataset;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('bilingual model accessors use the current locale', function () {
    app()->setLocale('en');

    expect(new County(['name_ro' => 'Cluj', 'name_en' => 'Cluj County'])->name)
        ->toBe('Cluj County')
        ->and(new ResourceCategory(['name_ro' => 'Ghiduri', 'name_en' => 'Guides'])->name)
        ->toBe('Guides')
        ->and(new Resource(['title_ro' => 'Titlu', 'title_en' => 'Title'])->title)
        ->toBe('Title')
        ->and(new Organization(['description_ro' => 'Descriere', 'description_en' => 'Description'])->description)
        ->toBe('Description')
        ->and(new PartnerOrganization(['description_ro' => 'Descriere', 'description_en' => 'Description'])->description)
        ->toBe('Description')
        ->and(new StaticPage(['body_ro' => 'Conținut', 'body_en' => 'Content'])->body)
        ->toBe('Content')
        ->and(new ProfessionalResource(['title_ro' => 'Resursă', 'title_en' => 'Resource'])->title)
        ->toBe('Resource')
        ->and(new StatisticDataset(['narrative_ro' => 'Narațiune', 'narrative_en' => 'Narrative'])->narrative)
        ->toBe('Narrative')
        ->and(new StatisticDataPoint(['label_ro' => 'Etichetă', 'label_en' => 'Label'])->label)
        ->toBe('Label');
});

test('model attributes are cast to domain types', function () {
    $resource = new Resource([
        'type' => ResourceType::Guide->value,
        'status' => ResourceStatus::Published->value,
        'tags' => ['education'],
        'featured' => 1,
        'published_at' => now(),
    ]);
    $organization = new Organization([
        'organization_type' => OrganizationType::Ngo->value,
        'services' => ['support'],
        'is_published' => 1,
    ]);
    $submission = new ResourceSubmission([
        'type' => ResourceType::Document->value,
        'status' => SubmissionStatus::Pending->value,
        'reviewed_at' => now(),
    ]);
    $consultation = new Consultation([
        'status' => ConsultationStatus::Open->value,
        'urgency' => ConsultationUrgency::High->value,
    ]);
    $dataset = new StatisticDataset([
        'chart_type' => ChartType::Bar->value,
        'is_published' => 1,
        'published_at' => now(),
    ]);
    $dataPoint = new StatisticDataPoint(['value' => '12.50', 'metadata' => ['source' => 'CPC']]);
    $score = new IndexCountyScore(['index_type' => IndexType::Resilience->value, 'score' => '9.75']);

    expect($resource->type)->toBe(ResourceType::Guide)
        ->and($resource->status)->toBe(ResourceStatus::Published)
        ->and($resource->tags)->toBe(['education'])
        ->and($resource->featured)->toBeTrue()
        ->and($organization->organization_type)->toBe(OrganizationType::Ngo)
        ->and($organization->services)->toBe(['support'])
        ->and($submission->status)->toBe(SubmissionStatus::Pending)
        ->and($consultation->urgency)->toBe(ConsultationUrgency::High)
        ->and($dataset->chart_type)->toBe(ChartType::Bar)
        ->and($dataPoint->value)->toBeFloat()
        ->and($dataPoint->metadata)->toBe(['source' => 'CPC'])
        ->and($score->index_type)->toBe(IndexType::Resilience)
        ->and($score->score)->toBeFloat();
});

test('models expose their expected relationships and route keys', function () {
    expect((new County)->organizations())->toBeInstanceOf(HasMany::class)
        ->and((new County)->indexCountyScores())->toBeInstanceOf(HasMany::class)
        ->and((new ResourceCategory)->resources())->toBeInstanceOf(HasMany::class)
        ->and((new Resource)->resourceCategory())->toBeInstanceOf(BelongsTo::class)
        ->and((new Organization)->county())->toBeInstanceOf(BelongsTo::class)
        ->and((new ResourceSubmission)->reviewedBy())->toBeInstanceOf(BelongsTo::class)
        ->and((new ResourceSubmission)->resource())->toBeInstanceOf(BelongsTo::class)
        ->and((new Consultation)->messages())->toBeInstanceOf(HasMany::class)
        ->and((new ConsultationMessage)->consultation())->toBeInstanceOf(BelongsTo::class)
        ->and((new StatisticDataset)->dataPoints())->toBeInstanceOf(HasMany::class)
        ->and((new StatisticDataPoint)->dataset())->toBeInstanceOf(BelongsTo::class)
        ->and((new IndexCountyScore)->county())->toBeInstanceOf(BelongsTo::class)
        ->and((new User)->consultations())->toBeInstanceOf(HasMany::class)
        ->and((new Resource)->getRouteKeyName())->toBe('slug')
        ->and((new StaticPage)->getRouteKeyName())->toBe('slug')
        ->and((new ProfessionalResource)->getRouteKeyName())->toBe('slug')
        ->and((new StatisticDataset)->getRouteKeyName())->toBe('slug');
});

test('publication scopes filter and order records', function () {
    $category = ResourceCategory::create([
        'slug' => 'scope-test-guides',
        'name_ro' => 'Ghiduri test',
        'name_en' => 'Scope test guides',
    ]);

    Resource::create([
        'slug' => 'scope-test-published',
        'title_ro' => 'Publicată',
        'title_en' => 'Published',
        'description_ro' => 'Descriere',
        'description_en' => 'Description',
        'type' => ResourceType::Guide,
        'resource_category_id' => $category->id,
        'featured' => true,
        'status' => ResourceStatus::Published,
        'published_at' => now()->subDay(),
    ]);
    Resource::create([
        'slug' => 'scope-test-draft',
        'title_ro' => 'Ciornă',
        'title_en' => 'Draft',
        'description_ro' => 'Descriere',
        'description_en' => 'Description',
        'type' => ResourceType::Guide,
        'resource_category_id' => $category->id,
        'featured' => false,
        'status' => ResourceStatus::Draft,
    ]);

    PartnerOrganization::create(['name' => 'Scope Test Second', 'sort_order' => 2, 'is_published' => true]);
    PartnerOrganization::create(['name' => 'Scope Test First', 'sort_order' => 1, 'is_published' => true]);
    PartnerOrganization::create(['name' => 'Scope Test Hidden', 'sort_order' => 0, 'is_published' => false]);

    expect(
        Resource::published()->where('slug', 'like', 'scope-test-%')->pluck('slug')->all(),
    )->toBe(['scope-test-published'])
        ->and(
            Resource::featured()->where('slug', 'like', 'scope-test-%')->pluck('slug')->all(),
        )->toBe(['scope-test-published'])
        ->and(
            PartnerOrganization::published()->where('name', 'like', 'Scope Test %')->pluck('name')->all(),
        )->toBe(['Scope Test First', 'Scope Test Second']);
});
