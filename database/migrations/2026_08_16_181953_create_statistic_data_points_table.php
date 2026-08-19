<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistic_data_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_dataset_id')->constrained()->cascadeOnDelete();
            $table->string('label_ro');
            $table->string('label_en');
            $table->decimal('value', 12, 2);
            $table->string('group_key')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistic_data_points');
    }
};
