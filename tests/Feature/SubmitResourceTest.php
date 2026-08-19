<?php

use App\Models\ResourceSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows a visitor to submit a resource', function () {
    Livewire::test('pages::submit')
        ->set('title', 'Professional safety guide')
        ->set('description', 'A practical guide for child protection teams.')
        ->set('type', 'guide')
        ->set('category', 'Prevention')
        ->set('submitterName', 'Ana Pop')
        ->set('submitterEmail', 'ana@example.com')
        ->set('submitterOrganization', 'Example NGO')
        ->set('rightsConfirmed', true)
        ->set('reviewConfirmed', true)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    expect(ResourceSubmission::query()->where('submitter_email', 'ana@example.com')->exists())->toBeTrue();
});
