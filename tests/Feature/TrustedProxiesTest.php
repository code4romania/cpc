<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

test('application trusts proxy forwarded headers', function () {
    Route::get('/__test/trusted-proxy', fn (Request $request) => response()->json([
        'secure' => $request->secure(),
        'scheme' => $request->getScheme(),
    ]));

    $response = $this->call(
        'GET',
        '/__test/trusted-proxy',
        [],
        [],
        [],
        [
            'REMOTE_ADDR' => '10.0.0.1',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ],
    );

    $response->assertOk()
        ->assertJson([
            'secure' => true,
            'scheme' => 'https',
        ]);
});
