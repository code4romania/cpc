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
        foreach (['resources', 'resource_submissions'] as $table) {
            DB::table($table)->where('type', 'template')->update(['type' => 'printable']);
            DB::table($table)->where('type', 'material')->update(['type' => 'online']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['resources', 'resource_submissions'] as $table) {
            DB::table($table)->where('type', 'online')->update(['type' => 'material']);
        }
    }
};
