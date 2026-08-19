<?php

use App\Enums\ConsultationStatus;
use App\Enums\ResourceStatus;
use App\Enums\SubmissionStatus;
use App\Filament\Widgets\StatsOverview;
use App\Models\Consultation;
use App\Models\Organization;
use App\Models\Resource;
use App\Models\ResourceSubmission;
use App\Models\User;
use Livewire\Livewire;

test('admin dashboard shows platform stats', function () {
    $admin = User::factory()->admin()->create();

    Resource::factory()->create(['status' => ResourceStatus::Published, 'published_at' => now()]);
    Organization::factory()->create(['is_published' => true]);
    ResourceSubmission::factory()->create(['status' => SubmissionStatus::Pending]);
    Consultation::factory()->create(['status' => ConsultationStatus::Open]);
    User::factory()->unverifiedProfessional()->create();

    $this->actingAs($admin);

    Livewire::test(StatsOverview::class)
        ->assertSee(__('admin.stats.published_resources'))
        ->assertSee(__('admin.stats.organizations'))
        ->assertSee(__('admin.stats.pending_submissions'))
        ->assertSee(__('admin.stats.open_consultations'))
        ->assertSee(__('admin.stats.professionals_to_verify'));
});

test('admin can view dashboard with stats widget', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk()
        ->assertSee(__('admin.stats.published_resources'));
});
