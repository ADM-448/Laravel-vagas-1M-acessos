<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            
            $table->date('data_nascimento')->nullable();
            $table->enum('genero', ['masculino', 'feminino', 'outro', 'nao_informar'])->default('nao_informar');
            $table->boolean('pcd')->default(false);
            $table->text('pcd_detalhes')->nullable();
            
            $table->text('resumo_profissional')->nullable();
            $table->decimal('pretensao_salarial', 10, 2)->nullable();
            
            // Endereço e geolocalização do candidato (para o radar de vagas próximas)
            $table->string('cep', 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->string('curriculo_pdf_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->enum('disponibilidade', ['imediata', '15_dias', '30_dias', 'empregado'])->default('imediata');
            $table->boolean('visivel_banco_talentos')->default(true);
            $table->timestamps();

            $table->index(['cidade', 'estado']);
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
