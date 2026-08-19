<?php

namespace Database\Seeders;

use App\Models\ProfessionalResource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfessionalResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            ['Advanced Trauma-Informed Interview Techniques', 'Comprehensive guide for conducting sensitive interviews with trafficking survivors, including age-appropriate approaches and trauma-informed questioning strategies.', 'Investigation', 'PDF Guide', '2026-01-15', '3.2 MB'],
            ['Case Documentation Templates - Confidential', 'Standardized templates for documenting suspected trafficking cases while maintaining victim confidentiality and legal compliance.', 'Case Management', 'Template Pack', '2026-02-01', '1.8 MB'],
            ['Multi-Agency Coordination Protocol', 'Detailed protocols for coordinating with law enforcement, child protective services, and healthcare providers in trafficking cases.', 'Collaboration', 'PDF Guide', '2026-01-20', '2.5 MB'],
            ['Risk Assessment Matrix for Child Trafficking', 'Evidence-based assessment tool for evaluating trafficking risk levels and determining appropriate interventions.', 'Assessment', 'Interactive Tool', '2026-01-28', '4.1 MB'],
            ['Emergency Response Procedures', 'Step-by-step protocols for immediate response when trafficking is suspected or discovered, including safety planning and emergency contacts.', 'Emergency Response', 'Quick Reference', '2026-02-05', '1.2 MB'],
            ['Legal Considerations in Trafficking Cases', 'Overview of legal frameworks, reporting requirements, and considerations for professionals working with trafficking survivors.', 'Legal', 'PDF Guide', '2026-01-10', '2.8 MB'],
            ['Cultural Competency in Anti-Trafficking Work', 'Resources for providing culturally sensitive services to diverse populations affected by trafficking.', 'Cultural Competency', 'Video Series', '2026-01-25', '250 MB'],
            ['Forensic Interview Recording Guidelines', 'Best practices for recording forensic interviews with child trafficking victims, including legal and ethical considerations.', 'Investigation', 'PDF Guide', '2026-02-03', '1.9 MB'],
        ];

        foreach ($resources as [$title, $description, $category, $type, $updatedAt, $fileSize]) {
            ProfessionalResource::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title_ro' => $title,
                    'title_en' => $title,
                    'description_ro' => $description,
                    'description_en' => $description,
                    'category' => $category,
                    'type' => $type,
                    'file_path' => null,
                    'file_size' => $fileSize,
                    'is_published' => true,
                    'last_updated_at' => $updatedAt,
                ],
            );
        }
    }
}
