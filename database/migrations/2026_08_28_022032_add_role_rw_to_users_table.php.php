<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambahkan role 'rw' ke enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('warga', 'rt', 'rw', 'staff', 'admin') DEFAULT 'warga'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('warga', 'rt', 'staff', 'admin') DEFAULT 'warga'");
    }
};