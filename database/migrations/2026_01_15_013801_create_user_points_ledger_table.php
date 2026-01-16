<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_points_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained('gamification_events')->onDelete('cascade');
            $table->integer('points_amount'); // Pontos concedidos neste registro
            $table->string('related_entity_type')->nullable(); // Ex: 'App\Models\Hackathon'
            $table->unsignedBigInteger('related_entity_id')->nullable();
            $table->text('notes')->nullable(); // Observações opcionais
            $table->timestamp('created_at')->useCurrent();
            
            // Índices para performance
            $table->index(['user_id', 'created_at']);
            $table->index(['related_entity_type', 'related_entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_points_ledger');
    }
};
