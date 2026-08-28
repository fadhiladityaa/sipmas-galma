<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('rw_id')->nullable()->constrained('rws')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['rw_id']);
            $table->dropColumn('rw_id');
        });
    }
};