<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portais', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ex: "Portal de Vagas de Santos"
            $table->string('slug')->unique(); // Ex: "santos"
            $table->string('dominio_principal')->nullable()->unique(); // Ex: "vagas.santos.sp.gov.br"
            $table->string('subdominio')->nullable()->unique(); // Ex: "santos" (para santos.intalenti.com.br)
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('ibge_code', 7)->nullable()->index();
            $table->string('logo_url')->nullable();
            $table->string('brasao_url')->nullable();
            $table->string('cor_primaria', 7)->default('#0d6efd'); // Hex
            $table->string('cor_secundaria', 7)->default('#6c757d');
            $table->enum('status_licenca', ['ativa', 'bloqueada', 'cancelada', 'degustacao'])->default('ativa');
            $table->date('licenca_expira_em')->nullable();
            $table->boolean('exige_aprovacao_empresa')->default(false); // Moderação prévia de empresas
            $table->json('configuracoes')->nullable(); // Configurações extras de customização
            $table->timestamps();

            $table->index(['status_licenca', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portais');
    }
};
