<?php

namespace App\Actions;

use App\Models\Candidato;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CadastrarCandidatoAction
{
    /**
     * Realiza o cadastro atômico do candidato e dispara verificação de e-mail
     */
    public function execute(array $dados): User
    {
        return DB::transaction(function () use ($dados) {
            $cpfLimpo = preg_replace('/\D/', '', $dados['cpf']);
            $telefoneLimpo = preg_replace('/\D/', '', $dados['telefone'] ?? '');

            $user = User::create([
                'name' => $dados['name'],
                'email' => strtolower(trim($dados['email'])),
                'cpf' => $cpfLimpo,
                'telefone' => $telefoneLimpo,
                'tipo_usuario' => 'candidato',
                'status' => 'ativo',
                'password' => Hash::make($dados['password']),
            ]);

            Candidato::create([
                'user_id' => $user->id,
                'cidade' => $dados['cidade'] ?? null,
                'estado' => $dados['estado'] ?? null,
                'cep' => isset($dados['cep']) ? preg_replace('/\D/', '', $dados['cep']) : null,
                'visivel_banco_talentos' => true,
            ]);

            // Dispara evento nativo do Laravel para envio de e-mail de verificação
            event(new Registered($user));

            return $user;
        });
    }
}
