<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversas_chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas')->cascadeOnDelete();
            $table->foreignId('candidatura_id')->constrained('candidaturas')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('candidato_id')->constrained('candidatos')->cascadeOnDelete();
            $table->timestamp('ultima_mensagem_em')->nullable();
            $table->enum('status', ['aberto', 'encerrado'])->default('aberto');
            $table->timestamps();

            $table->unique(['vaga_id', 'candidato_id']);
            $table->index(['candidato_id', 'status']);
            $table->index(['empresa_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversas_chat');
    }
};
