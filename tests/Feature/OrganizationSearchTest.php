<?php

use App\Models\County;
use App\Models\Organization;
use Livewire\Livewire;

test('organization search matches services and county', function () {
    $county = County::factory()->create([
        'name_ro' => 'Județul Test',
        'name_en' => 'Test County',
    ]);

    $byService = Organization::factory()->create([
        'name' => 'Serviciu Unic',
        'description_ro' => 'Descriere',
        'description_en' => 'Description',
        'city' => 'Oraș',
        'services' => ['Consiliere specializată'],
        'county_id' => County::factory(),
        'is_published' => true,
    ]);

    $byCounty = Organization::factory()->create([
        'name' => 'Organizație Locală',
        'description_ro' => 'Descriere',
        'description_en' => 'Description',
        'city' => 'Oraș',
        'services' => ['Alt serviciu'],
        'county_id' => $county->id,
        'is_published' => true,
    ]);

    Livewire::test('pages::organizations-index')
        ->set('search', 'Consiliere specializată')
        ->assertSee('Serviciu Unic')
        ->assertDontSee('Organizație Locală');

    Livewire::test('pages::organizations-index')
        ->set('search', 'Județul Test')
        ->assertSee('Organizație Locală')
        ->assertDontSee('Serviciu Unic');

    $this->get('/ro/organizations')
        ->assertOk()
        ->assertSee(__('organizations.search_placeholder', [], 'ro'), false);
});
