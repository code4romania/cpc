<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('professional')->after('password');
            $table->string('organization')->nullable()->after('role');
            $table->string('professional_role')->nullable()->after('organization');
            $table->timestamp('verified_at')->nullable()->after('professional_role');
            $table->string('locale', 2)->default('ro')->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'organization',
                'professional_role',
                'verified_at',
                'locale',
            ]);
        });
    }
};
