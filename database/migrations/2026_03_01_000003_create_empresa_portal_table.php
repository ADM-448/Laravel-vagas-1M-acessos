<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa_portal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('portal_id')->constrained('portais')->cascadeOnDelete();
            $table->enum('status_moderacao', ['pendente', 'aprovado', 'rejeitado'])->default('aprovado');
            $table->foreignId('moderado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('moderado_em')->nullable();
            $table->text('motivo_rejeicao')->nullable();
            $table->timestamps();

            $table->unique(['empresa_id', 'portal_id']);
            $table->index(['portal_id', 'status_moderacao']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa_portal');
    }
};
