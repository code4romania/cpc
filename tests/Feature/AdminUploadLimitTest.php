<?php

use App\Filament\Resources\PartnerOrganizations\Pages\CreatePartnerOrganization;
use App\Filament\Resources\Professionals\Pages\CreateProfessional;
use App\Filament\Resources\Resources\Pages\CreateResource;
use App\Models\User;
use Livewire\Livewire;

test('admin file uploads state their size limit', function () {
    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(CreatePartnerOrganization::class)
        ->assertSee('Maximum file size: 5 MB.', false);

    Livewire::test(CreateResource::class)
        ->assertSee('Maximum file size: 50 MB.', false);

    Livewire::test(CreateProfessional::class)
        ->assertSee('Maximum file size: 50 MB.', false);
});
