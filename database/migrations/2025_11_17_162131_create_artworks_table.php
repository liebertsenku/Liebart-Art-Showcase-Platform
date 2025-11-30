<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            
            // Foreign key untuk User (Creator)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign key untuk Category
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            
            $table->string('image')->nullable(); // Path ke file: "artworks/namafile.jpg"
            
            // Rekomendasi: Gunakan JSON untuk Tags
            // Ini lebih fleksibel daripada string yang dipisah koma
            $table->json('tags')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};