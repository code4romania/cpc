<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CountySeeder::class,
            ResourceCategorySeeder::class,
            ResourceSeeder::class,
            OrganizationSeeder::class,
            PartnerOrganizationSeeder::class,
            StaticPageSeeder::class,
            ProfessionalResourceSeeder::class,
            StatisticDatasetSeeder::class,
        ]);
    }
}
