<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('statistic_datasets', function (Blueprint $table) {
            $table->string('number_value')->nullable()->after('chart_type');
        });

        $now = now();

        $cards = [
            ['slug' => 'total-cases-2024', 'number_value' => '823', 'title_ro' => 'Total cazuri 2024', 'title_en' => 'Total cases 2024', 'description_ro' => '+6.3% vs 2023', 'description_en' => '+6.3% vs 2023', 'sort_order' => 0],
            ['slug' => 'identified-victims', 'number_value' => '1,247', 'title_ro' => 'Victime identificate', 'title_en' => 'Identified victims', 'description_ro' => 'Copii sub 18 ani', 'description_en' => 'Children under 18', 'sort_order' => 1],
            ['slug' => 'conviction-rate', 'number_value' => '78%', 'title_ro' => 'Rata condamnărilor', 'title_en' => 'Conviction rate', 'description_ro' => '+12% vs 2023', 'description_en' => '+12% vs 2023', 'sort_order' => 2],
            ['slug' => 'recovered-victims', 'number_value' => '89%', 'title_ro' => 'Victime recuperate', 'title_en' => 'Recovered victims', 'description_ro' => '1,110 copii în siguranță', 'description_en' => '1,110 children safe', 'sort_order' => 3],
        ];

        foreach ($cards as $card) {
            DB::table('statistic_datasets')->updateOrInsert(
                ['slug' => $card['slug']],
                [
                    ...$card,
                    'chart_type' => 'number',
                    'is_published' => true,
                    'published_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('statistic_datasets')->whereIn('slug', [
            'total-cases-2024',
            'identified-victims',
            'conviction-rate',
            'recovered-victims',
        ])->delete();

        Schema::table('statistic_datasets', function (Blueprint $table) {
            $table->dropColumn('number_value');
        });
    }
};
