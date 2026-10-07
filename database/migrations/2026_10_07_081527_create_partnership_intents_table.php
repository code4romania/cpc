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
        Schema::create('partnership_intents', function (Blueprint $table) {
            $table->id();
            $table->string('entity_name');
            $table->string('entity_type');
            $table->string('activity_domain');
            $table->string('contact_name');
            $table->string('contact_role');
            $table->string('phone');
            $table->string('email');
            $table->text('intent');
            $table->boolean('personal_data_consent');
            $table->string('locale', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_intents');
    }
};
