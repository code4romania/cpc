<?php

test('root redirects to default locale', function () {
    $response = $this->get('/');

    $response->assertRedirect('/ro');
});

test('invalid locale returns not found', function () {
    $response = $this->get('/fr');

    $response->assertNotFound();
});

test('locale is applied to translations', function () {
    $response = $this->get('/ro');

    $response->assertOk();
    $response->assertSee('lang="ro"', false);
});

test('all public routes respond for both locales', function (string $path) {
    $this->get('/ro' . $path)->assertOk();
    $this->get('/en' . $path)->assertOk();
})->with([
    '',
    '/resources',
    '/statistics',
    '/organizations',
    '/submit',
    '/about',
    '/partner-organizations',
    '/terms',
    '/cookie-policy',
    '/privacy',
    '/accessibility',
]);
