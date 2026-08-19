<?php

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a verified professional to access the portal', function () {
    $user = User::factory()->verifiedProfessional()->create();
    $consultation = Consultation::factory()->for($user)->create();

    $this->actingAs($user);

    foreach ([
        '/ro/portal',
        '/ro/portal/resources',
        '/ro/portal/consultations',
        '/ro/portal/consultations/create',
        '/ro/portal/consultations/' . $consultation->id,
        '/ro/portal/profile',
    ] as $path) {
        $this->get($path)->assertSuccessful();
    }
});

it('redirects an unverified professional to the pending page', function () {
    $user = User::factory()->unverifiedProfessional()->create();

    $this->actingAs($user)
        ->get('/ro/portal')
        ->assertRedirect(route('auth.pending', ['locale' => 'ro']));
});
