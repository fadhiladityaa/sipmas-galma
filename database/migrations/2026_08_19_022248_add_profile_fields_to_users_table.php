<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->unique()->nullable()->after('email');
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->string('agama')->nullable()->after('alamat');
            $table->string('pekerjaan')->nullable()->after('agama');
            $table->string('nomor_hp', 20)->nullable()->after('pekerjaan');
            $table->string('ktp_path')->nullable()->after('nomor_hp');
            $table->string('kk_path')->nullable()->after('ktp_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                'alamat', 'agama', 'pekerjaan', 'nomor_hp', 'ktp_path', 'kk_path'
            ]);
        });
    }
};