<?php

use App\Models\County;
use App\Models\Resource;
use App\Models\StaticPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('seed application data migration populates production content', function () {
    expect(County::query()->count())->toBe(42)
        ->and(Resource::query()->count())->toBeGreaterThan(0)
        ->and(StaticPage::query()->where('slug', 'terms')->exists())->toBeTrue()
        ->and(User::query()->where('email', 'admin@cpc.test')->exists())->toBeTrue();
});
