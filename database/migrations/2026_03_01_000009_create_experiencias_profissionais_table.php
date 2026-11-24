<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiencias_profissionais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_id')->constrained('candidatos')->cascadeOnDelete();
            $table->string('cargo');
            $table->string('empresa');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->boolean('atual')->default(false);
            $table->text('descricao_atividades')->nullable();
            $table->timestamps();

            $table->index(['candidato_id', 'data_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiencias_profissionais');
    }
};
