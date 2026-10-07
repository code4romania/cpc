<?php

use App\Enums\AccountApprovalStatus;
use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Enums\UserRole;
use App\Filament\Resources\AccountRequests\Pages\ListAccountRequests;
use App\Models\Resource;
use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountRejected;
use App\Notifications\AccountRenewal;
use App\Notifications\AccountRequested;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

test('a visitor can request an MAI or ONG account', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();

    $this->from('/ro/register')->post('/register', [
        'name' => 'Maria Ionescu',
        'email' => 'maria@example.org',
        'organization' => 'ANITP',
        'reference_phone' => '0213118982',
        'account_role' => UserRole::Mai->value,
        'terms' => '1',
    ])->assertRedirect(route('auth.requested', ['locale' => 'ro']));

    $this->assertGuest();

    $user = User::query()->where('email', 'maria@example.org')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::Mai)
        ->and($user->approval_status)->toBe(AccountApprovalStatus::Pending)
        ->and($user->organization)->toBe('ANITP')
        ->and($user->reference_phone)->toBe('0213118982');

    Notification::assertSentTo($admin, AccountRequested::class);
});

test('an admin can approve an account request and the user can set a password', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $request = User::factory()->create([
        'role' => UserRole::Ngo,
        'approval_status' => AccountApprovalStatus::Pending,
        'professional_role' => null,
        'verified_at' => null,
        'email' => 'ong@example.org',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListAccountRequests::class)
        ->assertSee('ong@example.org')
        ->callAction(TestAction::make('approve')->table($request));

    $request->refresh();

    expect($request->approval_status)->toBe(AccountApprovalStatus::Approved)
        ->and($request->expires_at)->not->toBeNull();

    Notification::assertSentTo($request, AccountApproved::class);

    $url = URL::temporarySignedRoute('account.password', now()->addHour(), [
        'locale' => 'ro',
        'user' => $request,
    ]);

    $this->post($url, [
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertRedirect(route('account.index', ['locale' => 'ro']));

    $this->assertAuthenticatedAs($request);
});

test('an admin can reject an account request', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $request = User::factory()->create([
        'role' => UserRole::Ngo,
        'approval_status' => AccountApprovalStatus::Pending,
        'professional_role' => null,
    ]);

    $this->actingAs($admin);

    Livewire::test(ListAccountRequests::class)
        ->callAction(TestAction::make('reject')->table($request));

    expect($request->fresh()->approval_status)->toBe(AccountApprovalStatus::Rejected);

    Notification::assertSentTo($request, AccountRejected::class);
});

test('restricted resources are visible only to the matching account role', function () {
    $ngoResource = Resource::factory()->create([
        'title_en' => 'NGO only guide',
        'access_levels' => [ResourceAccess::Ngo->value],
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);
    $publicResource = Resource::factory()->create([
        'title_en' => 'Public guide',
        'access_levels' => [ResourceAccess::Public->value],
        'status' => ResourceStatus::Published,
        'published_at' => now(),
    ]);

    $this->get('/en/resources')
        ->assertSuccessful()
        ->assertSee('Public guide', false)
        ->assertDontSee('NGO only guide', false);

    $this->actingAs(User::factory()->organizationAccount()->create());

    $this->get('/en/resources')
        ->assertSee('NGO only guide', false)
        ->assertSee('Public guide', false);

    $this->actingAs(User::factory()->organizationAccount(UserRole::Mai)->create());

    $this->get('/en/resources')
        ->assertDontSee('NGO only guide', false);

    $this->get('/en/resources/'.$ngoResource->slug)->assertNotFound();
    $this->get('/en/resources/'.$publicResource->slug)->assertSuccessful();
});

test('expired organization accounts are notified and deleted after a month without renewal', function () {
    Notification::fake();

    $expired = User::factory()->organizationAccount()->create([
        'expires_at' => now()->subDay(),
        'renewal_notified_at' => null,
    ]);
    $abandoned = User::factory()->organizationAccount()->create([
        'expires_at' => now()->subMonth()->subDay(),
        'renewal_notified_at' => now()->subMonth(),
    ]);

    $this->artisan('accounts:expire')->assertSuccessful();

    Notification::assertSentTo($expired, AccountRenewal::class);
    expect($expired->fresh()->renewal_notified_at)->not->toBeNull()
        ->and(User::query()->find($abandoned->id))->toBeNull();
});

test('an approved account can change its email and delete itself', function () {
    $user = User::factory()->organizationAccount()->create([
        'email' => 'old@example.org',
        'password' => 'password',
    ]);

    $this->actingAs($user);

    Livewire::test('pages::account')
        ->set('email', 'new@example.org')
        ->call('updateEmail')
        ->assertHasNoErrors();

    expect($user->fresh()->email)->toBe('new@example.org');

    Livewire::test('pages::account')
        ->set('deletePassword', 'password')
        ->call('deleteAccount');

    $this->assertGuest();
    expect(User::query()->find($user->id))->toBeNull();
});
