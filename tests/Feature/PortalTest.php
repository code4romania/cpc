<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a verified professional to access the portal', function () {
    $user = User::factory()->verifiedProfessional()->create();

    $this->actingAs($user);

    foreach ([
        '/ro/portal',
        '/ro/portal/resources',
        '/ro/portal/profile',
    ] as $path) {
        $this->get($path)->assertSuccessful();
    }

    $this->get('/ro/portal')
        ->assertDontSee(__('portal.consultations', [], 'ro'), false);

    $this->get('/ro/portal/consultations')->assertNotFound();
});

it('redirects an unverified professional to the pending page', function () {
    $user = User::factory()->unverifiedProfessional()->create();

    $this->actingAs($user)
        ->get('/ro/portal')
        ->assertRedirect(route('auth.pending', ['locale' => 'ro']));
});
