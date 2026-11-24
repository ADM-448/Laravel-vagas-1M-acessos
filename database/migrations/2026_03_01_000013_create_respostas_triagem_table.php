<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respostas_triagem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidatura_id')->constrained('candidaturas')->cascadeOnDelete();
            $table->foreignId('pergunta_vaga_id')->constrained('perguntas_vaga')->cascadeOnDelete();
            $table->text('resposta');
            $table->boolean('reprovou_eliminatoria')->default(false);
            $table->timestamps();

            $table->unique(['candidatura_id', 'pergunta_vaga_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respostas_triagem');
    }
};
