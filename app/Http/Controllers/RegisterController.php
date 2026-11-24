<?php

namespace App\Http\Controllers;

use App\Actions\CadastrarCandidatoAction;
use App\Actions\CadastrarEmpresaAction;
use App\Actions\CadastrarPrefeituraAction;
use App\Models\Portal;
use App\Rules\Cnpj;
use App\Rules\Cpf;
use App\Services\EmpresaValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de cadastro de Candidato
     */
    public function showCandidatoForm(Request $request): View
    {
        $portal = app()->bound('portal') ? app('portal') : Portal::first();

        return view('auth.register-candidato', [
            'portal' => $portal,
            'returnTo' => $request->query('return_to', '/vagas'),
        ]);
    }

    /**
     * Processa o cadastro de Candidato
     */
    public function registerCandidato(Request $request, CadastrarCandidatoAction $action): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', new Cpf, 'unique:users,cpf'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $action->execute($validated);

        Auth::login($user);

        return redirect()->route('candidato.curriculo')
            ->with('success', 'Cadastro realizado com sucesso! Complete seu currículo para concorrer às vagas.');
    }

    /**
     * Exibe o formulário de cadastro de Empresa & RH Master
     */
    public function showEmpresaForm(Request $request): View
    {
        $portal = app()->bound('portal') ? app('portal') : Portal::first();

        return view('auth.register-empresa', [
            'portal' => $portal,
        ]);
    }

    /**
     * Processa o cadastro de Empresa & RH Master
     */
    public function registerEmpresa(Request $request, CadastrarEmpresaAction $action): RedirectResponse
    {
        $validated = $request->validate([
            'cnpj' => ['required', 'string', new Cnpj],
            'razao_social' => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'ramo_atividade' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2'],
            'cep' => ['nullable', 'string', 'max:10'],
            'nome_rh' => ['required', 'string', 'max:255'],
            'email_rh' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefone_rh' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $portal = app()->bound('portal') ? app('portal') : Portal::first();

        try {
            $resultado = $action->execute($validated, $portal);
            Auth::login($resultado['user']);

            return redirect()->route('rh.dashboard')
                ->with('success', 'Empresa cadastrada com sucesso! Bem-vindo ao painel do RH.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['cnpj' => $e->getMessage()]);
        }
    }

    /**
     * Exibe formulário para cadastrar ou aderir nova Prefeitura (Tenant)
     */
    public function showPrefeituraForm(): View
    {
        return view('auth.register-prefeitura');
    }

    /**
     * Processa o cadastro de Prefeitura
     */
    public function registerPrefeitura(Request $request, CadastrarPrefeituraAction $action): RedirectResponse
    {
        $validated = $request->validate([
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'size:2'],
            'ibge_code' => ['nullable', 'string', 'size:7', 'unique:portais,ibge_code'],
            'dominio_principal' => ['nullable', 'string', 'max:255', 'unique:portais,dominio_principal'],
            'nome_gestor' => ['required', 'string', 'max:255'],
            'email_gestor' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefone_gestor' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $resultado = $action->execute($validated);
        Auth::login($resultado['gestor']);

        return redirect()->route('prefeitura.observatorio')
            ->with('success', 'Portal Municipal configurado com sucesso! Bem-vindo ao Observatório de Empregos.');
    }

    /**
     * Endpoint API para autocompletar dados do CNPJ em tempo real na tela
     */
    public function consultaCnpj(string $cnpj): JsonResponse
    {
        $dados = EmpresaValidationService::consultarReceita($cnpj);
        return response()->json($dados);
    }
}
