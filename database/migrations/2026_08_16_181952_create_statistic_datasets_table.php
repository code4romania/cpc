<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistic_datasets', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('chart_type');
            $table->string('title_ro');
            $table->string('title_en');
            $table->text('description_ro')->nullable();
            $table->text('description_en')->nullable();
            $table->text('narrative_ro')->nullable();
            $table->text('narrative_en')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistic_datasets');
    }
};
