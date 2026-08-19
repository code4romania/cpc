<?php

use App\Filament\Resources\PartnerOrganizations\Pages\CreatePartnerOrganization;
use App\Models\PartnerOrganization;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('resource can attach a file to the media library', function () {
    Storage::fake('public');

    $resource = Resource::factory()->create();

    $resource->addMediaFromString('sample resource content')
        ->usingFileName('guide.pdf')
        ->toMediaCollection('file');

    expect($resource->fresh()->file_url)->not->toBeNull()
        ->and($resource->getFirstMedia('file'))->not->toBeNull();
});

test('partner organization can attach a logo to the media library', function () {
    Storage::fake('public');

    $partner = PartnerOrganization::factory()->create();

    $partner->addMediaFromString('fake-image-content')
        ->usingFileName('logo.png')
        ->toMediaCollection('logo');

    expect($partner->fresh()->logo_url)->not->toBeNull()
        ->and($partner->getFirstMedia('logo'))->not->toBeNull();
});

test('admin can upload partner logo via filament form', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    $file = UploadedFile::fake()->image('partner-logo.png');

    Livewire::test(CreatePartnerOrganization::class)
        ->fillForm([
            'name' => 'Media Test Partner',
            'description_ro' => 'Descriere test',
            'description_en' => 'Test description',
            'sort_order' => 1,
            'is_published' => true,
            'logo' => [$file],
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified();

    $partner = PartnerOrganization::query()->where('name', 'Media Test Partner')->first();

    expect($partner)->not->toBeNull()
        ->and($partner->logo_url)->not->toBeNull()
        ->and($partner->getFirstMedia('logo'))->not->toBeNull();
});
