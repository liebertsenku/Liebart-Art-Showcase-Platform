<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('moderation_reports', function (Blueprint $table) {
            // 1. Hapus foreign key artwork lama (karena kita mau ganti strukturnya)
            $table->dropForeign(['artwork_id']);
            $table->dropColumn('artwork_id');

            // 2. Tambahkan kolom Polymorphic (bisa diisi ID artwork atau ID comment)
            // Ini akan membuat kolom: reportable_id (bigint) & reportable_type (string)
            $table->morphs('reportable'); 
        });
    }

    public function down(): void
    {
        Schema::table('moderation_reports', function (Blueprint $table) {
            $table->dropMorphs('reportable');
            $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
        });
    }
};
