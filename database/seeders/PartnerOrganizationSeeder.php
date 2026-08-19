<?php

namespace Database\Seeders;

use App\Models\PartnerOrganization;
use Illuminate\Database\Seeder;

class PartnerOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            ['name' => 'ANITP', 'description_ro' => 'Agenția Națională Împotriva Traficului de Persoane.', 'description_en' => 'Romanian National Agency Against Trafficking in Persons.', 'url' => 'https://anitp.mai.gov.ro/'],
            ['name' => 'Code for Romania', 'description_ro' => 'Organizație de tehnologie civică pentru soluții digitale de interes public.', 'description_en' => 'Civic technology organization building digital solutions for the public good.', 'url' => 'https://www.code4.ro/'],
            ['name' => 'Guvernul României', 'description_ro' => 'Partener instituțional al platformei.', 'description_en' => 'Institutional partner of the platform.', 'url' => 'https://gov.ro/'],
            ['name' => 'Sinergy Hub', 'description_ro' => 'Partener pentru colaborare și inovare socială.', 'description_en' => 'Partner for collaboration and social innovation.', 'url' => null],
        ];

        foreach ($partners as $sortOrder => $partner) {
            PartnerOrganization::query()->updateOrCreate(
                ['name' => $partner['name']],
                [...$partner, 'logo_path' => null, 'sort_order' => $sortOrder, 'is_published' => true],
            );
        }
    }
}
