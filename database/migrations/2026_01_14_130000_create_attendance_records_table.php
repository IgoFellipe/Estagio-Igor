<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de registros de presença
     */
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hackathon_id')->constrained()->onDelete('cascade');
            $table->string('photo_path');
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();

            // Um aluno só pode ter um registro de presença por hackathon
            $table->unique(['user_id', 'hackathon_id'], 'unique_user_hackathon_attendance');
        });
    }

    /**
     * Reverte a migration
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
