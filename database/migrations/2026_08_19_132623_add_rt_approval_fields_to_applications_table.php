<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('applications', 'rt_id')) {
                $table->foreignId('rt_id')->nullable()->constrained('rts')->onDelete('set null');
            }
            if (!Schema::hasColumn('applications', 'rt_approved_at')) {
                $table->timestamp('rt_approved_at')->nullable();
            }
            if (!Schema::hasColumn('applications', 'rt_approved_by')) {
                $table->foreignId('rt_approved_by')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('applications', 'rt_rejection_reason')) {
                $table->text('rt_rejection_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Hapus hanya jika kolom ada
            if (Schema::hasColumn('applications', 'rt_id')) {
                $table->dropForeign(['rt_id']);
                $table->dropColumn('rt_id');
            }
            if (Schema::hasColumn('applications', 'rt_approved_by')) {
                $table->dropForeign(['rt_approved_by']);
                $table->dropColumn('rt_approved_by');
            }
            if (Schema::hasColumn('applications', 'rt_approved_at')) {
                $table->dropColumn('rt_approved_at');
            }
            if (Schema::hasColumn('applications', 'rt_rejection_reason')) {
                $table->dropColumn('rt_rejection_reason');
            }
        });
    }
};