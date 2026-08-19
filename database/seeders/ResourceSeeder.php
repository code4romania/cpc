<?php

namespace Database\Seeders;

use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var list<array{0: string, 1: string, 2: ResourceType, 3: string, 4: list<string>, 5: string, 6: string, 7: bool, 8?: string}> $resources */
        $resources = [
            ['Recognizing Warning Signs: A Complete Guide', 'A detailed guide for educators and healthcare workers on identifying behavioral and physical indicators of child trafficking and abuse. Includes practical observation checklists and guidance for schools, clinics, and social services.', ResourceType::Guide, 'Identificare și referire', ['warning signs', 'behavioral indicators', 'physical signs'], 'Dr. Maria Popescu', '2026-02-01', true],
            ['Quick Reference Card: Risk Indicators', 'A printable wallet-sized card listing critical indicators that may signal a child is at risk of trafficking or exploitation, emergency contacts, and reporting procedures.', ResourceType::Printable, 'Identificare și referire', ['risk indicators', 'quick reference', 'pocket guide'], 'Child Protection Institute', '2026-01-28', true],
            ['Understanding Child Trafficking: An Introduction', 'Educational video providing an overview of child trafficking in Romania, common recruitment scenarios, the grooming process, and legal obligations of mandatory reporters.', ResourceType::Video, 'Prevenire și educație', ['introduction', 'overview', 'training'], 'Prof. Ion Ionescu', '2026-01-25', true],
            ['Incident Reporting Template', 'A standardized template for documenting suspected cases while maintaining appropriate protocols and confidentiality.', ResourceType::Template, 'Notificare/Sesizare', ['documentation', 'reporting', 'protocol'], 'Ministry of Internal Affairs', '2026-02-05', false],
            ['Trauma-Informed Interview Techniques', 'Best practices for communicating with children who may have experienced trauma, ensuring safety and sensitivity.', ResourceType::Guide, 'Comunicare', ['trauma-informed', 'interview', 'communication'], 'Dr. Elena Dumitrescu', '2026-01-20', false],
            ['Safety Planning Worksheet', 'An interactive worksheet to help children and professionals develop personalized safety plans.', ResourceType::Printable, 'Prevenire și educație', ['safety planning', 'prevention', 'worksheet'], 'Save the Children Foundation', '2026-01-18', false],
            ['Case Study: Identifying Trafficking in Schools', 'Real-world anonymized case studies demonstrating how educators successfully identified and reported trafficking situations.', ResourceType::Document, 'Studii, analize și cercetări', ['case study', 'schools', 'real examples'], 'Dr. Maria Popescu', '2026-01-15', false],
            ['Legal Framework and Reporting Requirements', 'Overview of mandatory reporting laws, legal protections, and the reporting process in different jurisdictions.', ResourceType::Document, 'Legislație națională', ['legal', 'mandatory reporting', 'laws'], 'Ministry of Justice', '2026-01-12', false],
            ['Cultural Competency in Child Protection', 'Video training on recognizing how cultural factors can influence the identification and response to trafficking risks.', ResourceType::Video, 'Prevenire și educație', ['cultural competency', 'diversity', 'training'], 'Prof. Ana Gheorghe', '2026-01-10', false],
            ['Information Sheet for Parents and Caregivers', 'A printable information sheet for parents about online safety, grooming tactics, and protective measures.', ResourceType::Printable, 'Prevenire și educație', ['parent resources', 'online safety', 'prevention'], 'Child Protection Institute', '2026-01-08', false],
            ['Multi-Agency Collaboration Protocol', 'Template for establishing collaborative relationships between schools, health services, police, and social services.', ResourceType::Template, 'Studii, analize și cercetări', ['multi-agency', 'collaboration', 'protocol'], 'Ministry of Education', '2026-01-05', false],
            ['Online Exploitation Warning Signs', 'Comprehensive guide to identifying signs of online grooming, exploitation, and trafficking recruitment.', ResourceType::Guide, 'Identificare și referire', ['online safety', 'digital exploitation', 'grooming'], 'Dr. Elena Dumitrescu', '2026-01-03', false],
            ['Self-Care for Professionals', 'Resources and strategies for managing vicarious trauma and maintaining mental health while working in child protection.', ResourceType::Material, 'Training/Dezvoltare profesională', ['self-care', 'trauma', 'mental health'], 'Prof. Ion Ionescu', '2025-12-28', false],
            ['Emergency Response Checklist', 'Step-by-step checklist for immediate actions when a child is identified as being in imminent danger.', ResourceType::Printable, 'Notificare/Sesizare', ['emergency', 'checklist', 'immediate action'], 'Ministry of Internal Affairs', '2025-12-25', false],
            ['Survivor Testimonies and Recovery Stories', 'Video compilation of survivor stories, shared with consent, highlighting the importance of early intervention.', ResourceType::Video, 'Studii, analize și cercetări', ['survivors', 'recovery', 'testimonies'], 'Save the Children Foundation', '2025-12-20', false],
            ['Age-Adapted Prevention Curriculum', 'Educational materials for teaching children of different ages about body autonomy, trusted adults, and seeking help.', ResourceType::Material, 'Prevenire și educație', ['curriculum', 'education', 'age-appropriate'], 'Ministry of Education', '2025-12-15', false],
            ['Public Awareness Campaign Kit', 'Complete materials for running community awareness campaigns: posters, flyers, and social media content.', ResourceType::Material, 'Comunicare', ['campaign', 'awareness', 'promotional materials'], 'Child Protection Institute', '2026-02-10', true],
            ['Social Media Messaging Guide', 'Strategies and templates for effective communication about child protection on social media platforms.', ResourceType::Guide, 'Comunicare', ['social media', 'communication', 'strategies'], 'Prof. Ana Gheorghe', '2026-02-08', false],
            ['Prevention Campaign Video', 'Professional video material for use in child trafficking information and prevention campaigns.', ResourceType::Video, 'Comunicare', ['video', 'campaign', 'prevention'], 'Ministry of Internal Affairs', '2026-02-06', false],
            ['Recognizing Signs of Child Trafficking and Abuse', 'Detailed educational video presenting behavioral and physical warning signs and intervention procedures.', ResourceType::Video, 'Identificare și referire', ['warning signs', 'indicators', 'video training', 'intervention'], 'Child Protection Institute', '2026-03-12', true, 'https://www.youtube.com/watch?v=QpUAwWkkXn0'],
            ['Child Trafficking Prevention Strategies', 'Video presentation on risk factors, educational programs, resilience building, and inter-institutional collaboration.', ResourceType::Video, 'Prevenire și educație', ['prevention', 'strategies', 'education', 'collaboration'], 'Ministry of Education', '2026-03-12', true, 'https://www.youtube.com/watch?v=vyK3snrzDtU'],
            ['Trauma-Informed Interventions in Child Protection', 'Video material on trauma theory, sensitive communication, safe environments, and long-term recovery strategies.', ResourceType::Video, 'Comunicare', ['trauma-informed', 'intervention', 'recovery', 'therapeutic techniques'], 'Dr. Elena Dumitrescu', '2026-03-12', true, 'https://www.youtube.com/watch?v=hEFuM4pBXmM'],
            ['Response and Reporting Protocols in Trafficking Cases', 'Video guide on case documentation, reporting to authorities, multi-agency coordination, and legal protection for reporters.', ResourceType::Video, 'Notificare/Sesizare', ['reporting', 'protocols', 'documentation', 'legal procedures'], 'Ministry of Internal Affairs', '2026-03-12', true, 'https://youtu.be/idgODMK3FhI'],
            ['Multi-Disciplinary Collaboration in Child Protection', 'Video material on roles, responsibilities, plan coordination, inter-agency communication, and multidisciplinary teams.', ResourceType::Video, 'Studii, analize și cercetări', ['collaboration', 'multi-disciplinary team', 'coordination', 'partnerships'], 'National Institute of Social Assistance', '2026-03-12', true, 'https://youtu.be/C2W9Zh9f7DY'],
        ];

        $categories = ResourceCategory::query()->pluck('id', 'name_ro');

        foreach ($resources as $resource) {
            $title = $resource[0];
            $description = $resource[1];
            $type = $resource[2];
            $category = $resource[3];
            $tags = $resource[4];
            $author = $resource[5];
            $publishedAt = $resource[6];
            $featured = $resource[7];
            $videoUrl = $resource[8] ?? null;

            Resource::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title_ro' => $title,
                    'title_en' => $title,
                    'description_ro' => $description,
                    'description_en' => $description,
                    'type' => $type->value,
                    'resource_category_id' => $categories->get($category),
                    'tags' => $tags,
                    'author' => $author,
                    'download_url' => $type === ResourceType::Video ? null : '#',
                    'video_url' => $videoUrl ?? ($type === ResourceType::Video ? '#' : null),
                    'featured' => $featured,
                    'status' => ResourceStatus::Published->value,
                    'published_at' => $publishedAt,
                ],
            );
        }
    }
}
