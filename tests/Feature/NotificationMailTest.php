<?php

use App\Actions\ApproveResourceSubmission;
use App\Filament\Resources\ResourceSubmissions\Pages\ListResourceSubmissions;
use App\Models\County;
use App\Models\PartnershipIntent;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use App\Models\User;
use App\Notifications\PartnershipIntentReceived;
use App\Notifications\ProfessionalVerified;
use App\Notifications\ResourceSubmissionApproved;
use App\Notifications\ResourceSubmissionReceived;
use App\Notifications\ResourceSubmissionRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('submitting a resource or a partnership intent emails admins immediately', function () {
    Storage::fake('local');
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $editor = User::factory()->editor()->create();
    $county = County::factory()->create(['name_ro' => 'Cluj', 'name_en' => 'Cluj']);
    $category = ResourceCategory::factory()->create([
        'name_ro' => 'Prevenire',
        'name_en' => 'Prevention',
    ]);

    Livewire::test('pages::submit')
        ->set('title', 'Professional safety guide')
        ->set('description', 'A practical guide for child protection teams.')
        ->set('type', 'guide')
        ->set('category', $category->name_en)
        ->set('language', 'en')
        ->set('createdOn', '2026-03-01')
        ->set('targetAudience', 'Social workers')
        ->set('submitterName', 'Ana Pop')
        ->set('submitterEmail', 'ana@example.com')
        ->set('submitterOrganization', 'Example NGO')
        ->set('counties', [$county->name_ro])
        ->set('files', [UploadedFile::fake()->create('guide.pdf', 100, 'application/pdf')])
        ->set('rightsConfirmed', true)
        ->set('reviewConfirmed', true)
        ->call('submit')
        ->assertHasNoErrors();

    Notification::assertSentTo([$admin, $editor], ResourceSubmissionReceived::class);

    Livewire::test('pages::partnership')
        ->set('entityName', 'Asociația Exemplu')
        ->set('entityType', 'ngo')
        ->set('activityDomain', 'Protecția copilului')
        ->set('contactName', 'Maria Ionescu')
        ->set('contactRole', 'Director')
        ->set('phone', '0215550101')
        ->set('email', 'maria@example.org')
        ->set('intent', 'Vrem să contribuim cu formări.')
        ->set('personalDataConsent', true)
        ->call('submit')
        ->assertHasNoErrors();

    Notification::assertSentTo([$admin, $editor], PartnershipIntentReceived::class);
    expect(PartnershipIntent::query()->where('email', 'maria@example.org')->exists())->toBeTrue();
});

test('approving or rejecting a resource submission emails the submitter immediately', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $approved = ResourceSubmission::factory()->create([
        'submitter_email' => 'approved@example.org',
        'title' => 'Approved guide',
    ]);
    $rejected = ResourceSubmission::factory()->create([
        'submitter_email' => 'rejected@example.org',
        'title' => 'Rejected guide',
    ]);

    app(ApproveResourceSubmission::class)($approved, $admin);

    Notification::assertSentOnDemand(
        ResourceSubmissionApproved::class,
        fn (ResourceSubmissionApproved $notification, array $channels, object $notifiable): bool => $notifiable->routes['mail'] === 'approved@example.org',
    );

    $this->actingAs($admin);

    Livewire::test(ListResourceSubmissions::class)
        ->callTableAction('reject', $rejected, ['rejection_reason' => 'Needs a source.'])
        ->assertNotified();

    Notification::assertSentOnDemand(
        ResourceSubmissionRejected::class,
        fn (ResourceSubmissionRejected $notification, array $channels, object $notifiable): bool => $notifiable->routes['mail'] === 'rejected@example.org',
    );

    expect(new ProfessionalVerified)->not->toBeInstanceOf(ShouldQueue::class)
        ->and(new ResourceSubmissionApproved($approved))->not->toBeInstanceOf(ShouldQueue::class);
});
