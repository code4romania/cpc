<?php

test('the public site uses the ZEROTRAFIC name, logo, and favicon', function () {
    $this->get('/ro')
        ->assertSuccessful()
        ->assertSee('ZEROTRAFIC', false)
        ->assertSee('images/brand/logo.png', false)
        ->assertSee('favicon.png', false);
});
