<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_ro');
            $table->string('title_en');
            $table->text('description_ro');
            $table->text('description_en');
            $table->string('type');
            $table->foreignId('resource_category_id')->constrained()->cascadeOnDelete();
            $table->json('tags')->nullable();
            $table->string('author')->nullable();
            $table->string('download_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
