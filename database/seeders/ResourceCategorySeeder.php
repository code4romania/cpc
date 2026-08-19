<?php

namespace Database\Seeders;

use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResourceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name_ro' => 'Identificare și referire', 'name_en' => 'Identification and referral', 'color_bg' => '#dce9f5', 'color_text' => '#2a4c82', 'color_border' => '#2a4c82'],
            ['name_ro' => 'Prevenire și educație', 'name_en' => 'Prevention and education', 'color_bg' => '#ede9f4', 'color_text' => '#7950a4', 'color_border' => '#7950a4'],
            ['name_ro' => 'Notificare/Sesizare', 'name_en' => 'Notification/Reporting', 'color_bg' => '#e8e7f2', 'color_text' => '#242159', 'color_border' => '#242159'],
            ['name_ro' => 'Comunicare', 'name_en' => 'Communication', 'color_bg' => '#e3edf5', 'color_text' => '#648baa', 'color_border' => '#648baa'],
            ['name_ro' => 'Legislație națională', 'name_en' => 'National legislation', 'color_bg' => '#d5e3f0', 'color_text' => '#1d3d6e', 'color_border' => '#1d3d6e'],
            ['name_ro' => 'Legislație internațională', 'name_en' => 'International legislation', 'color_bg' => '#d8eaf5', 'color_text' => '#1a5580', 'color_border' => '#1a5580'],
            ['name_ro' => 'Studii, analize și cercetări', 'name_en' => 'Studies, analyses and research', 'color_bg' => '#eae8f5', 'color_text' => '#4a3d8a', 'color_border' => '#4a3d8a'],
            ['name_ro' => 'Training/Dezvoltare profesională', 'name_en' => 'Training/Professional development', 'color_bg' => '#f0edf7', 'color_text' => '#6b4faa', 'color_border' => '#6b4faa'],
        ];

        foreach ($categories as $sortOrder => $category) {
            ResourceCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name_ro'])],
                [...$category, 'sort_order' => $sortOrder],
            );
        }
    }
}
