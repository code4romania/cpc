<?php

use Database\Seeders\StaticPageSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new StaticPageSeeder)->run();

        DB::table('static_pages')
            ->whereNotIn('slug', ['terms', 'privacy', 'home', 'about', 'contact'])
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
