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
