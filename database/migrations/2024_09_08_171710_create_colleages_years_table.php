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
        Schema::create('colleages_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colleage_id')
                ->constrained('colleages')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('year_id')
                ->constrained('years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleages_years');
    }
};
