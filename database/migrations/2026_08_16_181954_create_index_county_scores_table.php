<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('index_county_scores', function (Blueprint $table) {
            $table->id();
            $table->string('index_type')->index();
            $table->foreignId('county_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 8, 2);
            $table->unsignedSmallInteger('year');
            $table->timestamps();

            $table->unique(['index_type', 'county_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('index_county_scores');
    }
};
