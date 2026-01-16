<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gamification_events', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Ex: 'presence_confirmed', 'hackathon_win_1st'
            $table->string('name'); // Nome legível
            $table->integer('points'); // Quantidade de XP
            $table->string('icon')->nullable(); // Ícone (heroicon name ou emoji)
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gamification_events');
    }
};
