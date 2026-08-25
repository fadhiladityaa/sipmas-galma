<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Tambahkan processed_at jika belum ada
            if (!Schema::hasColumn('applications', 'processed_at')) {
                $table->timestamp('processed_at')->nullable();
            }
            // Tambahkan issued_at jika belum ada
            if (!Schema::hasColumn('applications', 'issued_at')) {
                $table->timestamp('issued_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'processed_at')) {
                $table->dropColumn('processed_at');
            }
            if (Schema::hasColumn('applications', 'issued_at')) {
                $table->dropColumn('issued_at');
            }
        });
    }
};