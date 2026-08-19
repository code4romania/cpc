<?php

namespace Database\Seeders;

use App\Enums\ChartType;
use App\Models\StatisticDataPoint;
use App\Models\StatisticDataset;
use Illuminate\Database\Seeder;

class StatisticDatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datasets = [
            [
                'slug' => 'cases-per-year',
                'chart_type' => ChartType::Bar,
                'title_ro' => 'Evoluția cazurilor de trafic (2019-2024)',
                'title_en' => 'Evolution of trafficking cases (2019-2024)',
                'description_ro' => 'Cazuri de trafic de copii raportate anual în România.',
                'description_en' => 'Child trafficking cases reported annually in Romania.',
                'narrative_ro' => 'Datele indică o tendință de creștere, de la 245 de cazuri în 2019 la 423 în 2024.',
                'narrative_en' => 'The data shows an upward trend, from 245 cases in 2019 to 423 in 2024.',
                'points' => [['2019', '2019', 245], ['2020', '2020', 289], ['2021', '2021', 312], ['2022', '2022', 356], ['2023', '2023', 398], ['2024', '2024', 423]],
            ],
            [
                'slug' => 'regional-distribution',
                'chart_type' => ChartType::Bar,
                'title_ro' => 'Distribuția regională a cazurilor (2024)',
                'title_en' => 'Regional distribution of cases (2024)',
                'description_ro' => 'Distribuția cazurilor pe regiuni de dezvoltare.',
                'description_en' => 'Distribution of cases by development region.',
                'narrative_ro' => 'București-Ilfov a înregistrat cele mai multe cazuri, urmată de Nord-Est și Sud-Est.',
                'narrative_en' => 'Bucharest-Ilfov recorded the most cases, followed by the North-East and South-East.',
                'points' => [['București-Ilfov', 'Bucharest-Ilfov', 156], ['Nord-Vest', 'North-West', 98], ['Centru', 'Centre', 87], ['Nord-Est', 'North-East', 134], ['Sud-Est', 'South-East', 112], ['Sud-Muntenia', 'South-Muntenia', 89], ['Sud-Vest Oltenia', 'South-West Oltenia', 67], ['Vest', 'West', 78]],
            ],
            [
                'slug' => 'age-distribution',
                'chart_type' => ChartType::Pie,
                'title_ro' => 'Distribuția pe grupe de vârstă',
                'title_en' => 'Distribution by age group',
                'description_ro' => 'Distribuția procentuală a victimelor pe categorii de vârstă.',
                'description_en' => 'Percentage distribution of victims by age category.',
                'narrative_ro' => 'Grupa 12-14 ani este cea mai vulnerabilă, reprezentând 38% din victimele identificate.',
                'narrative_en' => 'The 12-14 age group is the most vulnerable, representing 38% of identified victims.',
                'points' => [['0-6 ani', 'Ages 0-6', 12, null, ['color' => '#2a4c82']], ['7-11 ani', 'Ages 7-11', 23, null, ['color' => '#7950a4']], ['12-14 ani', 'Ages 12-14', 38, null, ['color' => '#648baa']], ['15-18 ani', 'Ages 15-18', 27, null, ['color' => '#242159']]],
            ],
            [
                'slug' => 'exploitation-types',
                'chart_type' => ChartType::Bar,
                'title_ro' => 'Tipuri de exploatare',
                'title_en' => 'Types of exploitation',
                'description_ro' => 'Clasificarea cazurilor după forma dominantă de exploatare.',
                'description_en' => 'Classification of cases by dominant form of exploitation.',
                'narrative_ro' => 'Munca forțată este cea mai frecventă formă, urmată de exploatarea sexuală și cerșetorie.',
                'narrative_en' => 'Forced labour is the most common form, followed by sexual exploitation and begging.',
                'points' => [['Muncă forțată', 'Forced labour', 234], ['Exploatare sexuală', 'Sexual exploitation', 189], ['Cerșetorie', 'Begging', 156], ['Activități ilegale', 'Illegal activities', 98], ['Alte forme', 'Other forms', 67]],
            ],
            [
                'slug' => 'monthly-trends',
                'chart_type' => ChartType::Line,
                'title_ro' => 'Tendințe lunare 2024',
                'title_en' => 'Monthly trends 2024',
                'description_ro' => 'Evoluția lunară a cazurilor noi și a victimelor identificate.',
                'description_en' => 'Monthly evolution of new cases and identified victims.',
                'narrative_ro' => 'Ambele serii ating un vârf în luna iulie și scad treptat în a doua jumătate a anului.',
                'narrative_en' => 'Both series peak in July and gradually decline during the second half of the year.',
                'points' => [
                    ['Ian', 'Jan', 32, 'cases'], ['Ian', 'Jan', 45, 'victims'], ['Feb', 'Feb', 28, 'cases'], ['Feb', 'Feb', 38, 'victims'],
                    ['Mar', 'Mar', 35, 'cases'], ['Mar', 'Mar', 52, 'victims'], ['Apr', 'Apr', 38, 'cases'], ['Apr', 'Apr', 56, 'victims'],
                    ['Mai', 'May', 42, 'cases'], ['Mai', 'May', 61, 'victims'], ['Iun', 'Jun', 45, 'cases'], ['Iun', 'Jun', 68, 'victims'],
                    ['Iul', 'Jul', 48, 'cases'], ['Iul', 'Jul', 72, 'victims'], ['Aug', 'Aug', 41, 'cases'], ['Aug', 'Aug', 59, 'victims'],
                    ['Sep', 'Sep', 39, 'cases'], ['Sep', 'Sep', 54, 'victims'], ['Oct', 'Oct', 36, 'cases'], ['Oct', 'Oct', 49, 'victims'],
                    ['Nov', 'Nov', 33, 'cases'], ['Nov', 'Nov', 44, 'victims'], ['Dec', 'Dec', 31, 'cases'], ['Dec', 'Dec', 42, 'victims'],
                ],
            ],
        ];

        foreach ($datasets as $sortOrder => $data) {
            $points = $data['points'];
            unset($data['points']);

            $dataset = StatisticDataset::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    ...$data,
                    'chart_type' => $data['chart_type']->value,
                    'is_published' => true,
                    'published_at' => now(),
                    'sort_order' => $sortOrder,
                ],
            );

            foreach ($points as $pointSortOrder => $point) {
                [$labelRo, $labelEn, $value] = $point;
                $groupKey = $point[3] ?? null;

                StatisticDataPoint::query()->updateOrCreate(
                    [
                        'statistic_dataset_id' => $dataset->getKey(),
                        'label_ro' => $labelRo,
                        'group_key' => $groupKey,
                    ],
                    [
                        'label_en' => $labelEn,
                        'value' => $value,
                        'metadata' => $point[4] ?? null,
                        'sort_order' => $pointSortOrder,
                    ],
                );
            }
        }
    }
}
