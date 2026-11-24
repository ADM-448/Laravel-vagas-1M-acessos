<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens_sso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('portal_id')->nullable()->constrained('portais')->cascadeOnDelete();
            $table->string('token', 80)->unique();
            $table->string('target_url')->nullable();
            $table->timestamp('expira_em');
            $table->boolean('utilizado')->default(false);
            $table->timestamps();

            $table->index(['token', 'utilizado', 'expira_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens_sso');
    }
};
