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
