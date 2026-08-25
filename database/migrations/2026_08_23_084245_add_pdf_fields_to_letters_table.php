<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            if (!Schema::hasColumn('letters', 'pdf_path')) {
                $table->string('pdf_path')->nullable()->after('content');
            }
            if (!Schema::hasColumn('letters', 'signed_pdf_path')) {
                $table->string('signed_pdf_path')->nullable()->after('pdf_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['pdf_path', 'signed_pdf_path']);
        });
    }
};