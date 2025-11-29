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
        Schema::create('challenge_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('submission_id')->constrained('challenge_submissions')->cascadeOnDelete();
            $table->enum('position', ['1', '2', '3']); // Juara 1, 2, 3
            $table->timestamps();

            // Pastikan 1 posisi hanya ada 1 pemenang per challenge
            $table->unique(['challenge_id', 'position']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_winners');
    }
};
