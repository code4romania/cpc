<?php

use App\Models\PartnerOrganization;

test('partner organization cards show the logo, name, website, and a short description', function () {
    $partner = PartnerOrganization::factory()->create([
        'name' => 'Asociația Exemplu',
        'description_ro' => 'O descriere scurtă despre partener.',
        'url' => 'https://exemplu.ro',
        'is_published' => true,
    ]);

    $this->get('/ro/partner-organizations')
        ->assertSuccessful()
        ->assertSee($partner->name, false)
        ->assertSee('https://exemplu.ro', false)
        ->assertSee('line-clamp-5', false)
        ->assertSee('O descriere scurtă despre partener.', false);
});
