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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->string('application_number')->unique();
            $table->enum('status', ['draft', 'submitted', 'assigned', 'in_progress', 'waiting_approval', 'approved', 'issued', 'rejected', 'revision_required'])->default('draft');
            $table->json('data')->nullable(); // field dinamis (tanggal_acara, lokasi, dll)
            $table->text('notes')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
