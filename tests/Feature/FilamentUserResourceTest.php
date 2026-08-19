<?php

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use App\Notifications\ProfessionalVerified;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('professional cannot access admin panel', function () {
    $user = User::factory()->verifiedProfessional()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

test('admin can access admin panel', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});

test('admin can verify professional from users table', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $professional = User::factory()->unverifiedProfessional()->create();

    $this->actingAs($admin);

    Livewire::test(ListUsers::class)
        ->callTableAction('verify', $professional)
        ->assertNotified();

    expect($professional->refresh()->verified_at)->not->toBeNull();

    Notification::assertSentTo($professional, ProfessionalVerified::class);
});

test('admin user seeder creates admin account', function () {
    $this->seed(AdminUserSeeder::class);

    $admin = User::query()->where('email', 'admin@cpc.test')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->isAdmin())->toBeTrue()
        ->and($admin->canAccessPanel(filament()->getPanel('admin')))->toBeTrue();
});
