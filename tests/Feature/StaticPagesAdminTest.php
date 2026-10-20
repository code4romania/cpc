<?php

use App\Filament\Resources\StaticPages\Pages\EditStaticPage;
use App\Filament\Resources\StaticPages\Pages\ListStaticPages;
use App\Models\StaticPage;
use App\Models\User;
use Livewire\Livewire;

test('static pages are limited to the managed set and cannot be created or deleted', function () {
    $this->actingAs(User::factory()->admin()->create());

    expect(StaticPage::query()->pluck('slug')->sort()->values()->all())
        ->toBe(['about', 'contact', 'home', 'privacy', 'terms']);

    Livewire::test(ListStaticPages::class)
        ->assertSee('terms')
        ->assertSee('privacy')
        ->assertSee('home')
        ->assertSee('about')
        ->assertSee('contact')
        ->assertDontSee('accessibility')
        ->assertDontSee('Create');

    Livewire::test(EditStaticPage::class, ['record' => 'about'])
        ->assertSee('You can edit the text and images in the existing content. Maximum image size: 5 MB.', false)
        ->assertSee('wire:name="App\\Filament\\Resources\\StaticPages\\Pages\\EditStaticPage"', false);
});

test('an admin can edit an existing homepage block without adding a new one', function () {
    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(EditStaticPage::class, ['record' => 'home'])
        ->assertFormSet([
            'blocks.emergency_title.ro' => 'Raportare de urgență',
            'blocks.feat_edu_title.ro' => 'Materiale educaționale',
        ])
        ->set('data.blocks.emergency_title.ro', 'Titlu de urgență editat')
        ->set('data.blocks.emergency_title.en', 'Edited emergency title')
        ->call('save')
        ->assertHasNoFormErrors();

    $this->get('/ro')
        ->assertSuccessful()
        ->assertSee('Titlu de urgență editat', false)
        ->assertSee('Materiale educaționale', false);

    $this->get('/en')
        ->assertSuccessful()
        ->assertSee('Edited emergency title', false);
});
