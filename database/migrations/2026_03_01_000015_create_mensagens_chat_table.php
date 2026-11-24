<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens_chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversa_id')->constrained('conversas_chat')->cascadeOnDelete();
            $table->foreignId('remetente_id')->constrained('users')->cascadeOnDelete();
            $table->text('mensagem');
            $table->string('anexo_path')->nullable();
            $table->timestamp('lida_em')->nullable();
            $table->timestamps();

            $table->index(['conversa_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens_chat');
    }
};
