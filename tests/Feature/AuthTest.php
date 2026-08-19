<?php

use App\Enums\ProfessionalRole;
use App\Enums\UserRole;
use App\Models\User;

test('login page renders in romanian', function () {
    $this->get('/ro/login')
        ->assertOk()
        ->assertSee(__('auth.login_title', [], 'ro'), false);
});

test('register page renders in english', function () {
    $this->get('/en/register')
        ->assertOk()
        ->assertSee(__('auth.register_title', [], 'en'), false);
});

test('professional can register and is unverified', function () {
    $response = $this->from('/ro/register')->post('/register', [
        'name' => 'Jane Professional',
        'email' => 'jane@example.com',
        'organization' => 'ANITP',
        'professional_role' => ProfessionalRole::SocialWorker->value,
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => '1',
    ]);

    $response->assertRedirect(route('auth.pending', ['locale' => 'ro']));

    $user = User::query()->where('email', 'jane@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::Professional)
        ->and($user->verified_at)->toBeNull()
        ->and($user->organization)->toBe('ANITP')
        ->and($user->professional_role)->toBe(ProfessionalRole::SocialWorker);

    $this->assertAuthenticatedAs($user);
});

test('unverified professional is redirected from portal to pending', function () {
    $user = User::factory()->unverifiedProfessional()->create();

    $this->actingAs($user)
        ->get('/ro/portal')
        ->assertRedirect(route('auth.pending', ['locale' => 'ro']));
});

test('verified professional can access portal', function () {
    $user = User::factory()->verifiedProfessional()->create();

    $this->actingAs($user)
        ->get('/ro/portal')
        ->assertOk()
        ->assertSee('Professional Portal', false);
});

test('professional can log in and is redirected to pending when unverified', function () {
    $user = User::factory()->unverifiedProfessional()->create([
        'email' => 'pro@example.com',
        'password' => 'password',
    ]);

    $this->from('/ro/login')->post('/login', [
        'email' => 'pro@example.com',
        'password' => 'password',
    ])->assertRedirect(route('auth.pending', ['locale' => 'ro']));

    $this->assertAuthenticatedAs($user);
});

test('admin cannot log in via public fortify login', function () {
    User::factory()->admin()->create([
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);

    $this->from('/ro/login')
        ->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])
        ->assertRedirect('/ro/login');

    $this->assertGuest();
});

test('pending page requires authentication', function () {
    $this->get('/ro/auth/pending')->assertRedirect();
});
