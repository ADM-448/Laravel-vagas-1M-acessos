<?php

namespace App\Http\Controllers;

use App\Actions\CadastrarCandidatoAction;
use App\Models\Candidato;
use App\Models\CursoHabilidade;
use App\Models\ExperienciaProfissional;
use App\Models\FormacaoAcademica;
use App\Rules\Cpf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CandidatoController extends Controller
{
    /**
     * Tela de Cadastro de Candidato
     */
    public function create(): View
    {
        $portais = \App\Models\Portal::where('status_licenca', 'ativa')
            ->orderBy('cidade')
            ->get();

        return view('candidato.cadastro', [
            'portais' => $portais,
        ]);
    }

    /**
     * Processa o Cadastro do Candidato com validações estritas
     */
    public function store(Request $request, CadastrarCandidatoAction $action): RedirectResponse
    {
        // Sanitiza CPF e Telefone (remove pontos, traços e parênteses) antes da validação
        // para que a regra 'unique:users,cpf' compare o valor limpo com o banco de dados
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')),
            'telefone' => preg_replace('/\D/', '', (string) $request->input('telefone')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,filter', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', new Cpf, 'unique:users,cpf'],
            'telefone' => ['required', 'string', new \App\Rules\CelularWhatsapp],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name.required' => 'Informe seu nome completo.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'email.required' => 'Informe seu endereço de e-mail.',
            'email.email' => 'Informe um endereço de e-mail válido (exemplo: seu.nome@gmail.com).',
            'email.unique' => 'Este e-mail já está em uso por outro candidato. Faça login.',
            'cpf.required' => 'Informe o número do seu CPF.',
            'cpf.unique' => 'Este CPF já está cadastrado na plataforma. Faça login com ele.',
            'telefone.required' => 'Informe seu celular com WhatsApp para que as empresas possam entrar em contato.',
            'password.required' => 'Defina uma senha de acesso.',
            'password.min' => 'A senha deve conter no mínimo 6 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        $user = $action->execute($validated);
        Auth::login($user);

        return redirect()->route('candidato.curriculo')
            ->with('success', 'Cadastro realizado com sucesso! Bem-vindo ao seu Currículo Digital.');
    }

    /**
     * Tela de Login exclusiva para Candidatos
     */
    public function showLogin(): View
    {
        return view('candidato.login');
    }

    /**
     * Processa o Login do Candidato
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Suporte para login tanto por E-mail quanto por CPF limpo
        $loginInput = trim($credentials['email']);
        $cpfLimpo = preg_replace('/\D/', '', $loginInput);

        $field = (strlen($cpfLimpo) === 11 && ctype_digit($cpfLimpo)) ? 'cpf' : 'email';
        $authAttempt = [
            $field => ($field === 'cpf') ? $cpfLimpo : $loginInput,
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($authAttempt, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! Auth::user()->isCandidato()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Esta conta não possui perfil de candidato.']);
            }

            return redirect()->intended(route('candidato.curriculo'));
        }

        return back()->withErrors([
            'email' => 'E-mail, CPF ou senha incorretos.',
        ])->onlyInput('email');
    }

    /**
     * Tela de visualização e edição do Currículo
     */
    public function curriculo(): View
    {
        $user = Auth::user();
        $candidato = $user->candidato;

        if (! $candidato) {
            $candidato = Candidato::create(['user_id' => $user->id]);
        }

        return view('candidato.curriculo', [
            'user' => $user,
            'candidato' => $candidato->load(['experiencias', 'formacoes', 'cursos']),
        ]);
    }

    /**
     * Atualiza dados pessoais e profissionais do candidato
     */
    public function updateDados(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $candidato = $user->candidato;

        $validatedUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:20'],
        ]);

        $validatedCandidato = $request->validate([
            'data_nascimento' => ['nullable', 'date'],
            'genero' => ['nullable', 'string'],
            'pcd' => ['nullable', 'boolean'],
            'pcd_detalhes' => ['nullable', 'string', 'max:500'],
            'pretensao_salarial' => ['nullable', 'numeric'],
            'resumo_profissional' => ['nullable', 'string', 'max:2000'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'disponibilidade' => ['nullable', 'string'],
        ]);

        $user->update($validatedUser);
        $candidato->update($validatedCandidato);

        return back()->with('success', 'Dados cadastrais atualizados com sucesso!');
    }

    /**
     * Adiciona uma Experiência Profissional
     */
    public function addExperiencia(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cargo' => ['required', 'string', 'max:150'],
            'empresa' => ['required', 'string', 'max:150'],
            'data_inicio' => ['required', 'date'],
            'data_fim' => ['nullable', 'date'],
            'atual' => ['nullable', 'boolean'],
            'descricao_atividades' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['candidato_id'] = Auth::user()->candidato->id;
        $validated['atual'] = $request->boolean('atual');

        ExperienciaProfissional::create($validated);

        return back()->with('success', 'Experiência profissional adicionada com sucesso!');
    }

    /**
     * Remove uma Experiência
     */
    public function deleteExperiencia(int $id): RedirectResponse
    {
        ExperienciaProfissional::where('id', $id)
            ->where('candidato_id', Auth::user()->candidato->id)
            ->delete();

        return back()->with('success', 'Experiência removida.');
    }

    /**
     * Adiciona Formação Acadêmica
     */
    public function addFormacao(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instituicao' => ['required', 'string', 'max:150'],
            'curso' => ['required', 'string', 'max:150'],
            'grau' => ['required', 'string'],
            'data_inicio' => ['required', 'date'],
            'data_fim' => ['nullable', 'date'],
            'status' => ['required', 'string'],
        ]);

        $validated['candidato_id'] = Auth::user()->candidato->id;
        FormacaoAcademica::create($validated);

        return back()->with('success', 'Formação acadêmica adicionada com sucesso!');
    }

    /**
     * Remove Formação Acadêmica
     */
    public function deleteFormacao(int $id): RedirectResponse
    {
        FormacaoAcademica::where('id', $id)
            ->where('candidato_id', Auth::user()->candidato->id)
            ->delete();

        return back()->with('success', 'Formação removida.');
    }

    /**
     * Adiciona Curso / Certificação
     */
    public function addCurso(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'instituicao' => ['nullable', 'string', 'max:150'],
            'carga_horaria' => ['nullable', 'integer', 'min:1'],
            'ano_conclusao' => ['nullable', 'integer', 'min:1970', 'max:' . (date('Y') + 1)],
        ]);

        $validated['candidato_id'] = Auth::user()->candidato->id;
        CursoHabilidade::create($validated);

        return back()->with('success', 'Curso / Certificação adicionada com sucesso!');
    }

    /**
     * Remove Curso
     */
    public function deleteCurso(int $id): RedirectResponse
    {
        CursoHabilidade::where('id', $id)
            ->where('candidato_id', Auth::user()->candidato->id)
            ->delete();

        return back()->with('success', 'Curso removido.');
    }

    /**
     * Minhas Candidaturas
     */
    public function candidaturas(): View
    {
        $candidato = Auth::user()->candidato;
        $candidaturas = $candidato
            ? $candidato->candidaturas()->with(['vaga.empresa'])->latest()->get()
            : collect();

        return view('candidato.candidaturas', [
            'candidaturas' => $candidaturas,
        ]);
    }
}
