<?php

use App\Enums\OrganizationType;
use App\Filament\Resources\Organizations\Pages\ListOrganizations;
use App\Filament\Widgets\StatsOverview;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('admin panel uses romanian labels for romanian admin', function () {
    $admin = User::factory()->admin()->create(['locale' => 'ro']);
    Organization::factory()->create([
        'name' => 'Test ONG Locale',
        'organization_type' => OrganizationType::Ngo,
    ]);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk()
        ->assertSee(__('admin.stats.published_resources', locale: 'ro'));

    Livewire::test(ListOrganizations::class)
        ->assertSee(OrganizationType::Ngo->label());
});

test('admin panel uses english labels for english admin', function () {
    $admin = User::factory()->admin()->create(['locale' => 'en']);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk()
        ->assertSee(__('admin.stats.published_resources', locale: 'en'))
        ->assertDontSee(__('admin.stats.published_resources', locale: 'ro'));

    Livewire::test(StatsOverview::class)
        ->assertSee(__('admin.stats.organizations', locale: 'en'));
});
