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
    Schema::create('challenge_submissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
        $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamp('submitted_at');
        $table->timestamps();

        // Validasi database: User hanya bisa submit 1 artwork per challenge
        $table->unique(['challenge_id', 'user_id']);
    });
}   
};
