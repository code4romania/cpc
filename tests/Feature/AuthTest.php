<?php

use App\Enums\AccountApprovalStatus;
use App\Enums\UserRole;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Models\User;
use Livewire\Livewire;

test('public navigation links to login and signup, and admins can assign staff and organization roles', function () {
    $this->get('/ro')
        ->assertOk()
        ->assertSee(localized_route('login'), false)
        ->assertSee(__('auth.login_nav', [], 'ro'), false)
        ->assertSee(__('auth.register_nav', [], 'ro'), false);

    expect(UserRole::options())->not->toHaveKey(UserRole::Professional->value)
        ->and(UserRole::options())->toHaveKey(UserRole::Mai->value)
        ->and(UserRole::options())->toHaveKey(UserRole::Ngo->value)
        ->and(UserRole::options())->toHaveKey(UserRole::Admin->value);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'MAI User',
            'email' => 'mai@example.com',
            'password' => 'password',
            'role' => UserRole::Mai->value,
            'organization' => 'MAI',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $account = User::query()->where('email', 'mai@example.com')->first();

    expect($account)->not->toBeNull()
        ->and($account->role)->toBe(UserRole::Mai)
        ->and($account->approval_status)->toBe(AccountApprovalStatus::Approved)
        ->and($account->expires_at)->not->toBeNull();
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
