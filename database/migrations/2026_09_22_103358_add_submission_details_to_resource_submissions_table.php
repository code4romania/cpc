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
        Schema::table('resource_submissions', function (Blueprint $table) {
            $table->string('organization_website')->nullable()->after('submitter_organization');
            $table->json('counties')->nullable()->after('organization_website');
            $table->string('phone')->nullable()->after('counties');
            $table->string('language')->nullable()->after('phone');
            $table->date('created_on')->nullable()->after('language');
            $table->string('target_audience')->nullable()->after('created_on');
            $table->json('tags')->nullable()->after('target_audience');
            $table->text('author_credentials')->nullable()->after('tags');
            $table->text('notes')->nullable()->after('author_credentials');
            $table->json('file_paths')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'organization_website',
                'counties',
                'phone',
                'language',
                'created_on',
                'target_audience',
                'tags',
                'author_credentials',
                'notes',
                'file_paths',
            ]);
        });
    }
};
