<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counties = [
            ['code' => 'AB', 'name_ro' => 'Alba', 'name_en' => 'Alba'],
            ['code' => 'AR', 'name_ro' => 'Arad', 'name_en' => 'Arad'],
            ['code' => 'AG', 'name_ro' => 'Argeș', 'name_en' => 'Argeș'],
            ['code' => 'BC', 'name_ro' => 'Bacău', 'name_en' => 'Bacău'],
            ['code' => 'BH', 'name_ro' => 'Bihor', 'name_en' => 'Bihor'],
            ['code' => 'BN', 'name_ro' => 'Bistrița-Năsăud', 'name_en' => 'Bistrița-Năsăud'],
            ['code' => 'BT', 'name_ro' => 'Botoșani', 'name_en' => 'Botoșani'],
            ['code' => 'BV', 'name_ro' => 'Brașov', 'name_en' => 'Brașov'],
            ['code' => 'BR', 'name_ro' => 'Brăila', 'name_en' => 'Brăila'],
            ['code' => 'B', 'name_ro' => 'București', 'name_en' => 'Bucharest'],
            ['code' => 'BZ', 'name_ro' => 'Buzău', 'name_en' => 'Buzău'],
            ['code' => 'CS', 'name_ro' => 'Caraș-Severin', 'name_en' => 'Caraș-Severin'],
            ['code' => 'CL', 'name_ro' => 'Călărași', 'name_en' => 'Călărași'],
            ['code' => 'CJ', 'name_ro' => 'Cluj', 'name_en' => 'Cluj'],
            ['code' => 'CT', 'name_ro' => 'Constanța', 'name_en' => 'Constanța'],
            ['code' => 'CV', 'name_ro' => 'Covasna', 'name_en' => 'Covasna'],
            ['code' => 'DB', 'name_ro' => 'Dâmbovița', 'name_en' => 'Dâmbovița'],
            ['code' => 'DJ', 'name_ro' => 'Dolj', 'name_en' => 'Dolj'],
            ['code' => 'GL', 'name_ro' => 'Galați', 'name_en' => 'Galați'],
            ['code' => 'GR', 'name_ro' => 'Giurgiu', 'name_en' => 'Giurgiu'],
            ['code' => 'GJ', 'name_ro' => 'Gorj', 'name_en' => 'Gorj'],
            ['code' => 'HR', 'name_ro' => 'Harghita', 'name_en' => 'Harghita'],
            ['code' => 'HD', 'name_ro' => 'Hunedoara', 'name_en' => 'Hunedoara'],
            ['code' => 'IL', 'name_ro' => 'Ialomița', 'name_en' => 'Ialomița'],
            ['code' => 'IS', 'name_ro' => 'Iași', 'name_en' => 'Iași'],
            ['code' => 'IF', 'name_ro' => 'Ilfov', 'name_en' => 'Ilfov'],
            ['code' => 'MM', 'name_ro' => 'Maramureș', 'name_en' => 'Maramureș'],
            ['code' => 'MH', 'name_ro' => 'Mehedinți', 'name_en' => 'Mehedinți'],
            ['code' => 'MS', 'name_ro' => 'Mureș', 'name_en' => 'Mureș'],
            ['code' => 'NT', 'name_ro' => 'Neamț', 'name_en' => 'Neamț'],
            ['code' => 'OT', 'name_ro' => 'Olt', 'name_en' => 'Olt'],
            ['code' => 'PH', 'name_ro' => 'Prahova', 'name_en' => 'Prahova'],
            ['code' => 'SM', 'name_ro' => 'Satu Mare', 'name_en' => 'Satu Mare'],
            ['code' => 'SJ', 'name_ro' => 'Sălaj', 'name_en' => 'Sălaj'],
            ['code' => 'SB', 'name_ro' => 'Sibiu', 'name_en' => 'Sibiu'],
            ['code' => 'SV', 'name_ro' => 'Suceava', 'name_en' => 'Suceava'],
            ['code' => 'TR', 'name_ro' => 'Teleorman', 'name_en' => 'Teleorman'],
            ['code' => 'TM', 'name_ro' => 'Timiș', 'name_en' => 'Timiș'],
            ['code' => 'TL', 'name_ro' => 'Tulcea', 'name_en' => 'Tulcea'],
            ['code' => 'VS', 'name_ro' => 'Vaslui', 'name_en' => 'Vaslui'],
            ['code' => 'VL', 'name_ro' => 'Vâlcea', 'name_en' => 'Vâlcea'],
            ['code' => 'VN', 'name_ro' => 'Vrancea', 'name_en' => 'Vrancea'],
        ];

        foreach ($counties as $county) {
            County::query()->updateOrCreate(['code' => $county['code']], $county);
        }
    }
}
