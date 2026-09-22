<?php

use Database\Seeders\StatisticDatasetSeeder;

test('statistics page matches the public design', function () {
    $this->seed(StatisticDatasetSeeder::class);

    $this->get('/ro/statistics')
        ->assertSuccessful()
        ->assertSee('Toate graficele pot fi integrate pe site-ul dvs.', false)
        ->assertSee('+6.3% vs 2023', false)
        ->assertSee('Copii sub 18 ani', false)
        ->assertSee('1,110 copii în siguranță', false)
        ->assertSee('Vulnerabilitate Structurală (V)', false)
        ->assertSee('↓ 1,4 puncte față de 2023', false)
        ->assertSee('Integrează date pe site-ul tău', false)
        ->assertSee('Evoluția cazurilor (2019-2024)', false)
        ->assertSee('Cazuri raportate', false)
        ->assertSee('Cazuri noi', false)
        ->assertSee('Tendințe lunare 2024', false);
});
