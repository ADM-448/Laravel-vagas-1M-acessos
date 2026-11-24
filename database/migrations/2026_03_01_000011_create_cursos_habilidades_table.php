<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos_habilidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_id')->constrained('candidatos')->cascadeOnDelete();
            $table->string('titulo');
            $table->string('instituicao')->nullable();
            $table->unsignedInteger('carga_horaria')->nullable();
            $table->year('ano_conclusao')->nullable();
            $table->timestamps();

            $table->index(['candidato_id', 'titulo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos_habilidades');
    }
};
