<?php

namespace App\Services;

use App\Models\Empresa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmpresaValidationService
{
    /**
     * Valida os dígitos verificadores do CNPJ (Algoritmo Oficial)
     */
    public static function validarDigitosCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        // Validação do 1º dígito
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Validação do 2º dígito
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Consulta situação cadastral da empresa na Receita Federal via BrasilAPI
     */
    public static function consultarReceita(string $cnpj): array
    {
        $cnpjLimpo = preg_replace('/\D/', '', $cnpj);

        try {
            $response = Http::timeout(5)->get("https://brasilapi.com.br/api/cnpj/v1/{$cnpjLimpo}");

            if ($response->successful()) {
                $dados = $response->json();
                return [
                    'valido' => true,
                    'razao_social' => $dados['razao_social'] ?? '',
                    'nome_fantasia' => $dados['nome_fantasia'] ?? '',
                    'situacao_cadastral' => $dados['descricao_situacao_cadastral'] ?? 'ATIVA',
                    'cidade' => $dados['municipio'] ?? '',
                    'estado' => $dados['uf'] ?? '',
                    'cep' => $dados['cep'] ?? '',
                    'logradouro' => $dados['logradouro'] ?? '',
                    'bairro' => $dados['bairro'] ?? '',
                    'ramo_atividade' => $dados['cnae_fiscal_descricao'] ?? '',
                ];
            }
        } catch (\Throwable $e) {
            Log::warning("Falha ao consultar CNPJ {$cnpjLimpo} na BrasilAPI: {$e->getMessage()}");
        }

        return ['valido' => false];
    }
}
