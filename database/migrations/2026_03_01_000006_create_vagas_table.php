<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portal_id')->constrained('portais')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('recrutador_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('titulo');
            $table->string('slug');
            $table->text('descricao');
            $table->text('requisitos')->nullable();
            $table->text('beneficios')->nullable();
            
            $table->enum('experiencia', ['indiferente', 'com', 'sem'])->default('indiferente');
            $table->string('escolaridade_minima')->nullable();
            $table->decimal('faixa_salarial_min', 10, 2)->nullable();
            $table->decimal('faixa_salarial_max', 10, 2)->nullable();
            $table->boolean('salario_a_combinar')->default(false);
            $table->string('tipo_contrato')->default('CLT'); // CLT, PJ, Estágio, etc.
            $table->enum('modalidade', ['presencial', 'hibrido', 'remoto'])->default('presencial');
            $table->enum('pcd', ['nao', 'sim', 'exclusivo_pcd'])->default('nao');
            
            // Localização da vaga (para radar geográfico)
            $table->string('cep', 8)->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade');
            $table->string('estado', 2);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->boolean('confidencial')->default(false); // Oculta nome da empresa
            $table->enum('status', ['publicada', 'rascunho', 'pausada', 'encerrada'])->default('publicada');
            $table->boolean('destaque')->default(false);
            
            // Contadores de alta performance (atualizados assincronamente via Redis)
            $table->unsignedBigInteger('visualizacoes_count')->default(0);
            $table->unsignedBigInteger('candidaturas_count')->default(0);
            
            $table->timestamp('publicada_em')->nullable();
            $table->timestamp('encerra_em')->nullable();
            $table->timestamps();

            // Índices de alta performance para 1M de acessos
            $table->index(['portal_id', 'status', 'created_at']);
            $table->index(['portal_id', 'modalidade', 'status']);
            $table->index(['portal_id', 'cidade', 'status']);
            $table->index(['empresa_id', 'status']);
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
