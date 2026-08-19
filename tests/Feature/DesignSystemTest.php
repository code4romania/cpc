<?php

use Illuminate\Support\Facades\Blade;

test('design system components render', function () {
    $html = Blade::render('<x-ui.button>Click</x-ui.button>');
    expect($html)->toContain('Click');

    $html = Blade::render('<x-ui.card>Card body</x-ui.card>');
    expect($html)->toContain('Card body');

    $html = Blade::render('<x-stat-card label="Cases" value="100" />');
    expect($html)->toContain('Cases')->toContain('100');
});

test('resource card renders translated strings', function () {
    app()->setLocale('ro');

    $html = Blade::render('<x-resource-card title="Test" description="Desc" author="ANITP" url="/ro/resources" :featured="true" :tags="[\'tag1\']" />');
    expect($html)->toContain(__('card.featured', [], 'ro'));
    expect($html)->toContain(__('card.read_more', [], 'ro'));
});

test('home page shows featured resources section', function () {
    $this->get('/ro')->assertOk()->assertSee(__('home.featured_title', [], 'ro'), false);
});
