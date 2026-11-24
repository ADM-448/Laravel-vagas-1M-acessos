<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('portal_id')->nullable()->constrained('portais')->cascadeOnDelete(); // Caso seja da equipe da prefeitura
            $table->enum('role', ['admin', 'gestor_vagas', 'recrutador', 'entrevistador'])->default('recrutador');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();

            $table->unique(['user_id', 'empresa_id', 'portal_id']);
            $table->index(['empresa_id', 'role', 'status']);
            $table->index(['portal_id', 'role', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa_user');
    }
};
