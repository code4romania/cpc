<?php

use App\Enums\PartnershipEntityType;
use App\Filament\Resources\PartnershipIntents\Pages\ListPartnershipIntents;
use App\Models\PartnershipIntent;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;

test('the partnership call to action is on contact and not on about', function () {
    $this->get('/ro/about')
        ->assertSuccessful()
        ->assertDontSee('Completează formularul', false);

    $this->get('/ro/contact')
        ->assertSuccessful()
        ->assertSee('Devino partener', false)
        ->assertSee('Completează formularul', false)
        ->assertSee(localized_route('partnership.index'), false);
});

test('a visitor can submit a partnership intent', function () {
    $this->get('/ro/partnership')
        ->assertSuccessful()
        ->assertSee('Formular intenție parteneriat', false)
        ->assertSee('Sunt de acord cu prelucrarea datelor cu caracter personal de către ANITP', false);

    Livewire::test('pages::partnership')
        ->set('entityName', 'Asociația Exemplu')
        ->set('entityType', PartnershipEntityType::Ngo->value)
        ->set('activityDomain', 'Protecția copilului')
        ->set('contactName', 'Maria Ionescu')
        ->set('contactRole', 'Director')
        ->set('phone', '021 555 0101')
        ->set('email', 'maria@example.org')
        ->set('intent', 'Vrem să contribuim cu formări pentru profesioniști.')
        ->set('personalDataConsent', true)
        ->call('submit')
        ->assertHasNoErrors();

    $intent = PartnershipIntent::query()->where('email', 'maria@example.org')->first();

    expect($intent)->not->toBeNull()
        ->and($intent->entity_type)->toBe(PartnershipEntityType::Ngo)
        ->and($intent->personal_data_consent)->toBeTrue();
});

test('admins can see partnership intents in the moderation tab', function () {
    $intent = PartnershipIntent::factory()->create([
        'entity_name' => 'Instituția Parteneră',
    ]);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(ListPartnershipIntents::class)
        ->assertSee($intent->entity_name)
        ->assertSee(mb_substr($intent->intent, 0, 40));
});

test('admins can open the full partnership intent', function () {
    $intent = PartnershipIntent::factory()->create([
        'entity_name' => 'Centrul de Prevenire',
        'activity_domain' => 'Formare profesională',
        'contact_role' => 'Coordonator programe',
        'phone' => '0722111222',
        'intent' => str_repeat('Vrem un parteneriat pe termen lung pentru prevenirea traficului. ', 8),
    ]);

    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(ListPartnershipIntents::class)
        ->mountAction(TestAction::make('view')->table($intent))
        ->assertMountedActionModalSee($intent->intent)
        ->assertMountedActionModalSee('Formare profesională')
        ->assertMountedActionModalSee('Coordonator programe')
        ->assertMountedActionModalSee('0722111222');
});
