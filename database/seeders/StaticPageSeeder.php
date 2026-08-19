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
                'slug' => 'terms',
                'title_ro' => 'Termeni și condiții',
                'title_en' => 'Terms and Conditions',
                'body_ro' => 'Platforma este destinată profesioniștilor din protecția copilului. Resursele trebuie folosite legal, confidențial și exclusiv în scop profesional. Materialele nu pot fi redistribuite sau comercializate fără permisiune. Conținutul este oferit cu scop informativ și nu înlocuiește judecata profesională, consilierea juridică sau protocoalele instituționale.',
                'body_en' => 'The platform is intended for child-protection professionals. Resources must be used lawfully, confidentially, and solely for professional purposes. Materials may not be redistributed or commercialized without permission. Content is informational and does not replace professional judgment, legal advice, or institutional protocols.',
            ],
            [
                'slug' => 'cookie-policy',
                'title_ro' => 'Politica privind cookie-urile',
                'title_en' => 'Cookie Policy',
                'body_ro' => 'Folosim cookie-uri strict necesare pentru autentificare, securitate și gestionarea sesiunii, precum și cookie-uri funcționale și analitice opționale. Preferințele pot fi gestionate din browser. Nu vindem date și nu urmărim informații despre victime sau copii aflați în situații de risc.',
                'body_en' => 'We use strictly necessary cookies for authentication, security, and session management, plus optional functional and analytics cookies. Preferences can be managed in your browser. We do not sell data or track information about victims or children at risk.',
            ],
            [
                'slug' => 'privacy',
                'title_ro' => 'Politica de confidențialitate',
                'title_en' => 'Privacy Policy',
                'body_ro' => 'Protejăm datele personale conform legislației aplicabile și colectăm numai informațiile necesare funcționării platformei. Nu trebuie încărcate date cu caracter personal despre victime sau copii aflați în situații de risc. Pentru solicitări privind datele personale, contactați administratorul platformei.',
                'body_en' => 'We protect personal data under applicable law and collect only information needed to operate the platform. Personally identifiable information about victims or children at risk must not be uploaded. Contact the platform administrator for privacy requests.',
            ],
            [
                'slug' => 'accessibility',
                'title_ro' => 'Declarație de accesibilitate',
                'title_en' => 'Accessibility Statement',
                'body_ro' => 'Ne propunem ca platforma să fie utilizabilă de cât mai multe persoane, inclusiv de utilizatorii tehnologiilor asistive. Lucrăm continuu la navigarea cu tastatura, contrast, structură semantică și alternative text. Ne puteți semnala orice barieră de accesibilitate.',
                'body_en' => 'We aim to make the platform usable by as many people as possible, including assistive-technology users. We continuously improve keyboard navigation, contrast, semantic structure, and text alternatives. Please report any accessibility barrier you encounter.',
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
