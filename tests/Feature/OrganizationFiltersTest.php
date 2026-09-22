<?php

use App\Enums\OrganizationType;
use App\Models\Organization;
use Livewire\Livewire;

test('organization filters list romanian counties and the four organization types', function () {
    $this->get('/ro/organizations')
        ->assertSuccessful()
        ->assertSee('Național', false)
        ->assertSee('Diaspora', false)
        ->assertSee('Instituții publice', false)
        ->assertSee('Organizații nonguvernamentale', false)
        ->assertSee('Companii/Societăți', false)
        ->assertSee('Grupuri de sprijin', false)
        ->assertDontSee('>international<', false)
        ->assertDontSee('>other<', false);
});

test('organization type filter matches the selected label', function () {
    $company = Organization::factory()->create([
        'name' => 'Companie Filtru',
        'organization_type' => OrganizationType::Company,
        'is_published' => true,
    ]);

    $ngo = Organization::factory()->create([
        'name' => 'Ong Filtru',
        'organization_type' => OrganizationType::Ngo,
        'is_published' => true,
    ]);

    Livewire::test('pages::organizations-index')
        ->set('types', [OrganizationType::Company->label()])
        ->assertSee($company->name)
        ->assertDontSee($ngo->name);
});
