<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        Schema::table('partner_organizations', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });

        Schema::table('professional_resources', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        Schema::table('resource_submissions', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('video_url');
        });

        Schema::table('partner_organizations', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('name');
        });

        Schema::table('professional_resources', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('type');
        });

        Schema::table('resource_submissions', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('submitter_organization');
        });
    }
};
