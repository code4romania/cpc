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
        Schema::table('users', function (Blueprint $table) {
            $table->string('reference_phone')->nullable()->after('organization');
            $table->string('approval_status')->default('approved')->after('verified_at');
            $table->timestamp('expires_at')->nullable()->after('approval_status');
            $table->timestamp('renewal_notified_at')->nullable()->after('expires_at');
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->json('access_levels')->nullable()->after('featured');
        });

        DB::table('resources')->whereNull('access_levels')->update([
            'access_levels' => json_encode(['public']),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['reference_phone', 'approval_status', 'expires_at', 'renewal_notified_at']);
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('access_levels');
        });
    }
};
