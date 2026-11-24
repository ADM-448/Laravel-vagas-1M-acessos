<?php

namespace App\Actions;

use App\Models\Empresa;
use App\Models\EmpresaUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CadastrarEmpresaAction
{
    /**
     * Realiza o cadastro atômico da Empresa, do Administrador (RH Master)
     * e associa aos municípios/portais parceiros selecionados.
     */
    public function execute(array $dados): array
    {
        return DB::transaction(function () use ($dados) {
            $cnpjLimpo = preg_replace('/\D/', '', $dados['cnpj']);
            $cpfLimpo = preg_replace('/\D/', '', $dados['rh_cpf']);
            $telRhLimpo = preg_replace('/\D/', '', $dados['rh_telefone'] ?? '');
            $telEmpresaLimpo = preg_replace('/\D/', '', $dados['telefone'] ?? '');

            // 1. Criação da Empresa
            $empresa = Empresa::create([
                'cnpj' => $cnpjLimpo,
                'razao_social' => $dados['razao_social'],
                'nome_fantasia' => $dados['nome_fantasia'] ?: $dados['razao_social'],
                'situacao_cadastral' => strtoupper($dados['situacao_cadastral'] ?? 'ATIVA'),
                'consulta_receita_at' => now(),
                'ramo_atividade' => $dados['ramo_atividade'] ?? null,
                'descricao' => $dados['descricao'] ?? null,
                'site' => $dados['site'] ?? null,
                'telefone' => $telEmpresaLimpo ?: $telRhLimpo,
                'email_contato' => strtolower(trim($dados['email_contato'] ?? $dados['rh_email'])),
                'cep' => isset($dados['cep']) ? preg_replace('/\D/', '', $dados['cep']) : null,
                'logradouro' => $dados['logradouro'] ?? null,
                'numero' => $dados['numero'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'cidade' => $dados['cidade'] ?? null,
                'estado' => strtoupper($dados['estado'] ?? 'SP'),
                'status' => 'ativo',
            ]);

            // 2. Vínculo da Empresa aos Portais Municipais
            if (!empty($dados['portais']) && is_array($dados['portais'])) {
                foreach ($dados['portais'] as $portalId) {
                    $empresa->portais()->attach($portalId, [
                        'status_moderacao' => 'aprovado',
                        'moderado_em' => now(),
                    ]);
                }
            }

            // 3. Criação do Usuário RH Master / Admin da Empresa
            $user = User::create([
                'name' => $dados['rh_nome'],
                'email' => strtolower(trim($dados['rh_email'])),
                'cpf' => $cpfLimpo,
                'telefone' => $telRhLimpo,
                'tipo_usuario' => 'empresa',
                'status' => 'ativo',
                'password' => Hash::make($dados['password']),
            ]);

            // 4. Associação de Permissão RBAC (Admin da Empresa)
            EmpresaUser::create([
                'user_id' => $user->id,
                'empresa_id' => $empresa->id,
                'portal_id' => !empty($dados['portais']) ? $dados['portais'][0] : null,
                'role' => 'admin',
                'status' => 'ativo',
            ]);

            event(new Registered($user));

            return [
                'empresa' => $empresa,
                'user' => $user,
            ];
        });
    }
}
