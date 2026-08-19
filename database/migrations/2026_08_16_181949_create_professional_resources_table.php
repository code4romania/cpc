<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professional_resources', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_ro');
            $table->string('title_en');
            $table->text('description_ro')->nullable();
            $table->text('description_en')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professional_resources');
    }
};
