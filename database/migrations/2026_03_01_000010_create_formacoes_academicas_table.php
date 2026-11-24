<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formacoes_academicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_id')->constrained('candidatos')->cascadeOnDelete();
            $table->string('instituicao');
            $table->string('curso');
            $table->enum('grau', [
                'ensino_fundamental',
                'ensino_medio',
                'tecnico',
                'superior_incompleto',
                'superior_completo',
                'pos_graduacao',
                'mestrado',
                'doutorado'
            ])->default('ensino_medio');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->enum('status', ['completo', 'cursando', 'interrompido'])->default('completo');
            $table->timestamps();

            $table->index(['candidato_id', 'grau']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formacoes_academicas');
    }
};
