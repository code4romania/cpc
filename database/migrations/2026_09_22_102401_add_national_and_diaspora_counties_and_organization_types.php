<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('organizations')
            ->where('organization_type', 'international')
            ->update(['organization_type' => 'ngo']);

        DB::table('organizations')
            ->where('organization_type', 'other')
            ->update(['organization_type' => 'support_group']);

        $now = now();

        foreach ([
            ['code' => 'NA', 'name_ro' => 'Național', 'name_en' => 'National'],
            ['code' => 'DS', 'name_ro' => 'Diaspora', 'name_en' => 'Diaspora'],
        ] as $county) {
            DB::table('counties')->updateOrInsert(
                ['code' => $county['code']],
                [...$county, 'created_at' => $now, 'updated_at' => $now],
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('organizations')
            ->where('organization_type', 'support_group')
            ->update(['organization_type' => 'other']);

        DB::table('counties')->whereIn('code', ['NA', 'DS'])->delete();
    }
};
