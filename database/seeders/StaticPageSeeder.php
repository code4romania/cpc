<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title_ro' => __('home.hero_title', [], 'ro'),
                'title_en' => __('home.hero_title', [], 'en'),
                'body_ro' => __('home.hero_subtitle', [], 'ro'),
                'body_en' => __('home.hero_subtitle', [], 'en'),
            ],
            [
                'slug' => 'about',
                'title_ro' => __('about.title', [], 'ro'),
                'title_en' => __('about.title', [], 'en'),
                'body_ro' => __('about.mission_body', [], 'ro'),
                'body_en' => __('about.mission_body', [], 'en'),
            ],
            [
                'slug' => 'contact',
                'title_ro' => __('contact.title', [], 'ro'),
                'title_en' => __('contact.title', [], 'en'),
                'body_ro' => __('contact.subtitle', [], 'ro'),
                'body_en' => __('contact.subtitle', [], 'en'),
            ],
            [
                'slug' => 'terms',
                'title_ro' => 'Termeni și condiții',
                'title_en' => 'Terms and Conditions',
                'body_ro' => 'Platforma este destinată profesioniștilor din protecția copilului. Resursele trebuie folosite legal, confidențial și exclusiv în scop profesional. Materialele nu pot fi redistribuite sau comercializate fără permisiune. Conținutul este oferit cu scop informativ și nu înlocuiește judecata profesională, consilierea juridică sau protocoalele instituționale.',
                'body_en' => 'The platform is intended for child-protection professionals. Resources must be used lawfully, confidentially, and solely for professional purposes. Materials may not be redistributed or commercialized without permission. Content is informational and does not replace professional judgment, legal advice, or institutional protocols.',
            ],
            [
                'slug' => 'privacy',
                'title_ro' => 'Politica de confidențialitate',
                'title_en' => 'Privacy Policy',
                'body_ro' => 'Protejăm datele personale conform legislației aplicabile și colectăm numai informațiile necesare funcționării platformei. Nu trebuie încărcate date cu caracter personal despre victime sau copii aflați în situații de risc. Pentru solicitări privind datele personale, contactați administratorul platformei.',
                'body_en' => 'We protect personal data under applicable law and collect only information needed to operate the platform. Personally identifiable information about victims or children at risk must not be uploaded. Contact the platform administrator for privacy requests.',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::query()->updateOrCreate(
                ['slug' => $page['slug']],
                [...$page, 'is_published' => true],
            );
        }
    }
}
