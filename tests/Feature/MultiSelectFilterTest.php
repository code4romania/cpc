<?php

use Livewire\Livewire;

test('multi select filter toggles options', function () {
    Livewire::test('multi-select-filter', [
        'label' => 'Category',
        'placeholder' => 'All',
        'options' => ['Guide', 'Video'],
        'selected' => [],
    ])
        ->set('selected', ['Guide'])
        ->assertSet('selected', ['Guide'])
        ->call('selectAll')
        ->assertSet('selected', ['Guide', 'Video'])
        ->call('clear')
        ->assertSet('selected', []);
});
