<?php

test('home page renders in romanian', function () {
    $response = $this->get('/ro');

    $response->assertOk();
    $response->assertSee(__('home.hero_title', [], 'ro'), false);
});

test('home page renders in english', function () {
    $response = $this->get('/en');

    $response->assertOk();
    $response->assertSee(__('home.hero_title', [], 'en'), false);
});

test('homepage statistics count up when scrolled into view', function () {
    $this->get('/ro')
        ->assertOk()
        ->assertSee('data-count-up="823"', false)
        ->assertSee('data-count-up="1247"', false)
        ->assertSee('data-count-up="78"', false)
        ->assertSee('data-count-up="89"', false)
        ->assertSee('IntersectionObserver', false);
});
