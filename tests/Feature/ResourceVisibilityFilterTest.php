<?php

use App\Enums\ResourceAccess;
use App\Filament\Resources\Resources\Pages\ListResources;
use App\Models\Resource;
use App\Models\User;
use Livewire\Livewire;

test('admins can filter resources by visibility', function () {
    $public = Resource::factory()->create([
        'slug' => 'visible-to-public',
        'title_ro' => 'Resursă publică',
        'access_levels' => [ResourceAccess::Public->value],
    ]);
    $mai = Resource::factory()->create([
        'slug' => 'visible-to-mai',
        'title_ro' => 'Resursă MAI',
        'access_levels' => [ResourceAccess::Mai->value],
    ]);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(ListResources::class)
        ->filterTable('access_levels', ResourceAccess::Mai->value)
        ->assertCanSeeTableRecords([$mai])
        ->assertCanNotSeeTableRecords([$public]);
});
