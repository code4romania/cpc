<?php

use App\Filament\Resources\ResourceSubmissions\Pages\ListResourceSubmissions;
use App\Models\ResourceSubmission;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('admins can view every field submitted with a resource', function () {
    Storage::fake('local');
    Storage::disk('local')->put('resource-submissions/guide.pdf', 'pdf-bytes');

    $submission = ResourceSubmission::factory()->create([
        'title' => 'Ghid de prevenire',
        'organization_website' => 'https://example.org',
        'phone' => '0210000000',
        'counties' => ['București', 'Cluj'],
        'target_audience' => 'Cadre didactice',
        'tags' => ['prevenire', 'școală'],
        'author_credentials' => 'Psiholog clinician',
        'notes' => 'Notă internă pentru revizuire',
        'file_paths' => ['resource-submissions/guide.pdf'],
    ]);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(ListResourceSubmissions::class)
        ->mountAction(TestAction::make('view')->table($submission))
        ->assertMountedActionModalSee('https://example.org')
        ->assertMountedActionModalSee('0210000000')
        ->assertMountedActionModalSee('București, Cluj')
        ->assertMountedActionModalSee('Cadre didactice')
        ->assertMountedActionModalSee('prevenire, școală')
        ->assertMountedActionModalSee('Psiholog clinician')
        ->assertMountedActionModalSee('Notă internă pentru revizuire')
        ->assertMountedActionModalSee('guide.pdf')
        ->assertMountedActionModalSee(__('admin.tabs.review'));
});

test('only admins and editors can download a submitted file', function () {
    Storage::fake('local');
    Storage::disk('local')->put('resource-submissions/guide.pdf', 'pdf-bytes');

    $submission = ResourceSubmission::factory()->create([
        'file_paths' => ['resource-submissions/guide.pdf'],
    ]);
    $url = route('resource-submissions.files.download', ['submission' => $submission, 'index' => 0]);

    $this->get($url)->assertRedirect();

    $this->actingAs(User::factory()->professional()->create())
        ->get($url)
        ->assertForbidden();

    $this->actingAs(User::factory()->admin()->create())
        ->get($url)
        ->assertSuccessful()
        ->assertDownload('guide.pdf');
});
