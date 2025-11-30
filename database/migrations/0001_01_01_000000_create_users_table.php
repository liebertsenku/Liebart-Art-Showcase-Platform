<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ini akan jadi "Nama Tampilan"
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // === KOLOM TAMBAHAN KITA ===
            $table->enum('role', ['admin', 'member', 'curator', 'curator_pending'])->default('member');
            $table->enum('status', ['active', 'pending'])->default('active');
            
            // Field untuk Profile Management (Member & Curator)
            $table->string('profile_photo_path', 2048)->nullable();
            $table->text('bio')->nullable();
            $table->json('external_links')->nullable(); // Untuk menyimpan { "instagram": "...", "behance": "..." }
            // ===========================

            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
