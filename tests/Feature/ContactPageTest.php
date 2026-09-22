<?php

test('contact page lists partner organizations and code for romania', function () {
    $this->get('/ro/contact')
        ->assertSuccessful()
        ->assertSee(__('contact.nav', [], 'ro'), false)
        ->assertSee(__('contact.organizations.anitp.name', [], 'ro'), false)
        ->assertSee('anitp@mai.gov.ro', false)
        ->assertSee(__('contact.organizations.code.name', [], 'ro'), false)
        ->assertSee('hello@code4.ro', false)
        ->assertSee('https://code4.ro', false);

    $this->get('/ro')
        ->assertSuccessful()
        ->assertSee(__('contact.nav', [], 'ro'), false)
        ->assertSee(localized_route('contact'), false)
        ->assertDontSee('/cookie-policy', false);

    $this->get('/ro/cookie-policy')->assertNotFound();
});
