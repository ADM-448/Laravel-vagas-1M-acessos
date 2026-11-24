<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perguntas_vaga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas')->cascadeOnDelete();
            $table->string('pergunta');
            $table->enum('tipo_resposta', ['sim_nao', 'texto', 'multipla_escolha'])->default('sim_nao');
            $table->json('opcoes')->nullable(); // Para múltipla escolha
            $table->boolean('obrigatoria')->default(true);
            $table->string('resposta_eliminatoria')->nullable(); // Resposta que desqualifica imediatamente
            $table->unsignedInteger('ordem')->default(1);
            $table->timestamps();

            $table->index(['vaga_id', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perguntas_vaga');
    }
};
