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
        Schema::create('moderation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users'); // Admin yang melakukan aksi
            $table->foreignId('report_id')->nullable()->constrained('moderation_reports')->nullOnDelete();
            $table->string('action'); // 'approve_report', 'reject_report', 'ban_user'
            $table->text('details')->nullable(); // Snapshot data atau alasan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderation_logs');
    }
};
