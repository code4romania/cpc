<?php

use App\Enums\UserRole;
use App\Models\User;

test('public navigation links to login and signup, and admins can only create staff roles', function () {
    $this->get('/ro')
        ->assertOk()
        ->assertSee(localized_route('login'), false)
        ->assertSee(__('auth.login_nav', [], 'ro'), false)
        ->assertSee(__('auth.register_nav', [], 'ro'), false);

    expect(UserRole::options())->not->toHaveKey(UserRole::Professional->value)
        ->and(UserRole::options())->not->toHaveKey(UserRole::Mai->value)
        ->and(UserRole::options())->not->toHaveKey(UserRole::Ngo->value)
        ->and(UserRole::options())->toHaveKey(UserRole::Admin->value);
});

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
