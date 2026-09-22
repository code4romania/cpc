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

test('public navigation and homepage header use white text', function () {
    $response = $this->get('/ro');

    $response->assertOk();
    $response->assertSee('text-white hover:bg-primary/40', false);
    $response->assertSee('text-xl md:text-2xl mb-8 text-white', false);
    $response->assertSee('!text-navy', false);
    $response->assertDontSee('text-xl md:text-2xl mb-8 text-muted', false);
});
