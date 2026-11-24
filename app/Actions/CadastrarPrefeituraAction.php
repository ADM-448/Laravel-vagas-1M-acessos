<?php

namespace App\Actions;

use App\Models\EmpresaUser;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CadastrarPrefeituraAction
{
    /**
     * Cadastra um novo Portal Municipal (Tenant) e seu primeiro Gestor Municipal
     */
    public function execute(array $dados): array
    {
        return DB::transaction(function () use ($dados) {
            $slug = Str::slug($dados['cidade'] . '-' . $dados['estado']);

            // 1. Cria o Portal Municipal
            $portal = Portal::create([
                'nome' => $dados['nome_portal'] ?? "Portal de Empregos de {$dados['cidade']}",
                'slug' => $slug,
                'dominio_principal' => $dados['dominio_principal'] ?? null,
                'subdominio' => $dados['subdominio'] ?? Str::slug($dados['cidade']),
                'cidade' => $dados['cidade'],
                'estado' => strtoupper($dados['estado']),
                'ibge_code' => $dados['ibge_code'] ?? null,
                'cor_primaria' => $dados['cor_primaria'] ?? '#0d6efd',
                'cor_secundaria' => $dados['cor_secundaria'] ?? '#6c757d',
                'status_licenca' => 'ativa',
                'licenca_expira_em' => now()->addYear(),
                'exige_aprovacao_empresa' => $dados['exige_aprovacao_empresa'] ?? false,
            ]);

            // 2. Cria o Gestor da Prefeitura
            $gestor = User::create([
                'name' => $dados['nome_gestor'],
                'email' => strtolower(trim($dados['email_gestor'])),
                'telefone' => preg_replace('/\D/', '', $dados['telefone_gestor'] ?? ''),
                'tipo_usuario' => 'prefeitura_admin',
                'status' => 'ativo',
                'password' => Hash::make($dados['password']),
            ]);

            // 3. Vincula o Gestor ao Portal
            EmpresaUser::create([
                'user_id' => $gestor->id,
                'portal_id' => $portal->id,
                'role' => 'admin',
                'status' => 'ativo',
            ]);

            // Dispara envio de e-mail de verificação
            event(new Registered($gestor));

            return [
                'portal' => $portal,
                'gestor' => $gestor,
            ];
        });
    }
}
