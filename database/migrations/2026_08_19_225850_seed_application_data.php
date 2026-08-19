<?php

use Database\Seeders\AdminUserSeeder;
use Database\Seeders\DemoDataSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new AdminUserSeeder)->run();
        (new DemoDataSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
