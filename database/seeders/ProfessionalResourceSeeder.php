<?php

namespace Database\Seeders;

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Models\ProfessionalResource;
use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProfessionalResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Schema::hasColumn('professional_resources', 'resource_category_id')) {
            return;
        }

        $resources = [
            ['Advanced Trauma-Informed Interview Techniques', 'Comprehensive guide for conducting sensitive interviews with trafficking survivors, including age-appropriate approaches and trauma-informed questioning strategies.', 'Investigation', ResourceType::Guide, '2026-01-15'],
            ['Case Documentation Templates - Confidential', 'Standardized templates for documenting suspected trafficking cases while maintaining victim confidentiality and legal compliance.', 'Case Management', ResourceType::Printable, '2026-02-01'],
            ['Multi-Agency Coordination Protocol', 'Detailed protocols for coordinating with law enforcement, child protective services, and healthcare providers in trafficking cases.', 'Collaboration', ResourceType::Guide, '2026-01-20'],
            ['Risk Assessment Matrix for Child Trafficking', 'Evidence-based assessment tool for evaluating trafficking risk levels and determining appropriate interventions.', 'Assessment', ResourceType::Online, '2026-01-28'],
            ['Emergency Response Procedures', 'Step-by-step protocols for immediate response when trafficking is suspected or discovered, including safety planning and emergency contacts.', 'Emergency Response', ResourceType::Document, '2026-02-05'],
            ['Legal Considerations in Trafficking Cases', 'Overview of legal frameworks, reporting requirements, and considerations for professionals working with trafficking survivors.', 'Legal', ResourceType::Guide, '2026-01-10'],
            ['Cultural Competency in Anti-Trafficking Work', 'Resources for providing culturally sensitive services to diverse populations affected by trafficking.', 'Cultural Competency', ResourceType::Video, '2026-01-25'],
            ['Forensic Interview Recording Guidelines', 'Best practices for recording forensic interviews with child trafficking victims, including legal and ethical considerations.', 'Investigation', ResourceType::Guide, '2026-02-03'],
        ];

        foreach ($resources as [$title, $description, $categoryName, $type, $publishedAt]) {
            $category = ResourceCategory::query()->firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name_ro' => $categoryName,
                    'name_en' => $categoryName,
                    'color_bg' => '#ede9f4',
                    'color_text' => '#7950a4',
                    'color_border' => '#7950a4',
                    'sort_order' => 100,
                ],
            );

            ProfessionalResource::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title_ro' => $title,
                    'title_en' => $title,
                    'description_ro' => $description,
                    'description_en' => $description,
                    'type' => $type,
                    'resource_category_id' => $category->getKey(),
                    'access_levels' => [
                        ResourceAccess::Ngo->value,
                        ResourceAccess::Mai->value,
                    ],
                    'status' => ResourceStatus::Published,
                    'published_at' => $publishedAt,
                ],
            );
        }
    }
}
