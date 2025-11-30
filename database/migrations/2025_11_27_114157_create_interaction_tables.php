<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Tabel Likes (Pivot)
    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
        $table->unique(['user_id', 'artwork_id']); // Satu user hanya bisa like 1x per artwork
    });

    // Tabel Favorites (Pivot)
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
        $table->unique(['user_id', 'artwork_id']);
    });

    // Tabel Comments
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        $table->text('body');
        $table->timestamps();
    });

    // Tabel Reports (Moderation Queue)
    Schema::create('moderation_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        $table->string('reason'); // SARA, Plagiarisme, Nudity, dll
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
    });
}
};
