<?php

test('application redirects to default locale home', function () {
    $response = $this->get('/');

    $response->assertRedirect('/ro');
});
