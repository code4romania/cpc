<?php

use App\Models\StaticPage;
use App\Support\StaticPageBlocks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->json('blocks')->nullable();
        });

        StaticPage::query()->each(function (StaticPage $page): void {
            $page->update([
                'blocks' => StaticPageBlocks::defaults($page->slug),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn('blocks');
        });
    }
};
