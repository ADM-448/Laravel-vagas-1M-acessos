<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas')->cascadeOnDelete();
            $table->foreignId('candidato_id')->constrained('candidatos')->cascadeOnDelete();
            
            $table->enum('etapa_pipeline', [
                'inscrito',
                'triagem',
                'entrevista',
                'proposta',
                'aprovado',
                'reprovado',
                'banco_reserva'
            ])->default('inscrito');
            
            $table->integer('score_compatibilidade')->default(0); // 0 a 100%
            $table->text('feedback_recrutador')->nullable();
            $table->string('motivo_reprovacao')->nullable();
            $table->timestamp('visualizado_em')->nullable(); // Recrutador abriu
            $table->timestamps();

            // Bloqueio atômico de candidatura duplicada
            $table->unique(['vaga_id', 'candidato_id']);
            $table->index(['vaga_id', 'etapa_pipeline']);
            $table->index(['candidato_id', 'etapa_pipeline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};
