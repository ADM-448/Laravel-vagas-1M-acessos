<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14)->unique(); // CNPJ limpo (14 dígitos)
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('situacao_cadastral')->default('ATIVA'); // Status Receita Federal
            $table->timestamp('consulta_receita_at')->nullable();
            $table->string('ramo_atividade')->nullable();
            $table->text('descricao')->nullable();
            $table->string('site')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email_contato')->nullable();

            // Endereço e geolocalização da sede/filial
            $table->string('cep', 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('status', ['ativo', 'bloqueado', 'pendente_validacao'])->default('ativo');
            $table->timestamps();

            $table->index(['cidade', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
