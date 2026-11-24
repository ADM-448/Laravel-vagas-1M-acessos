<?php

namespace App\Http\Controllers;

use App\Actions\CadastrarEmpresaAction;
use App\Models\Candidatura;
use App\Models\ConviteEquipe;
use App\Models\Empresa;
use App\Models\EmpresaUser;
use App\Models\PerguntaVaga;
use App\Models\Portal;
use App\Models\User;
use App\Models\Vaga;
use App\Rules\Cnpj;
use App\Rules\Cpf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    /**
     * Tela de Cadastro de Empresa
     */
    public function create(): View
    {
        $portais = Portal::where('status_licenca', 'ativa')
            ->orderBy('cidade')
            ->get();

        return view('empresa.cadastro', [
            'portais' => $portais,
        ]);
    }

    /**
     * Consulta CNPJ via API externa e checa duplicidade local
     */
    public function consultarCnpj(string $cnpj): JsonResponse
    {
        $cnpjLimpo = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpjLimpo) !== 14) {
            return response()->json([
                'success' => false,
                'message' => 'CNPJ deve conter 14 dígitos numéricos.',
            ], 422);
        }

        // Verifica duplicidade no banco de dados local
        $existente = Empresa::where('cnpj', $cnpjLimpo)->first();
        if ($existente) {
            return response()->json([
                'success' => false,
                'ja_cadastrado' => true,
                'message' => 'Este CNPJ já está cadastrado na plataforma (' . $existente->razao_social . '). Faça login.',
            ], 409);
        }

        // Tenta consultar na BrasilAPI pública
        try {
            $response = Http::timeout(4)->get("https://brasilapi.com.br/api/cnpj/v1/{$cnpjLimpo}");

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'origem' => 'receita',
                    'razao_social' => $data['razao_social'] ?? '',
                    'nome_fantasia' => $data['nome_fantasia'] ?? ($data['razao_social'] ?? ''),
                    'situacao_cadastral' => $data['descricao_situacao_cadastral'] ?? 'ATIVA',
                    'ramo_atividade' => $data['cnae_fiscal_descricao'] ?? '',
                    'telefone' => $data['ddd_telefone_1'] ?? '',
                    'email' => $data['email'] ?? '',
                    'cep' => $data['cep'] ?? '',
                    'logradouro' => $data['logradouro'] ?? '',
                    'numero' => $data['numero'] ?? '',
                    'complemento' => $data['complemento'] ?? '',
                    'bairro' => $data['bairro'] ?? '',
                    'cidade' => $data['municipio'] ?? '',
                    'estado' => $data['uf'] ?? 'SP',
                ]);
            }
        } catch (\Throwable $e) {
            // Em caso de falha de conexão com a API externa, permite preenchimento manual
        }

        return response()->json([
            'success' => true,
            'origem' => 'manual',
            'message' => 'Não foi possível buscar na Receita Federal automaticamente. Preencha os campos abaixo.',
        ]);
    }

    /**
     * Processa o Cadastro da Empresa e do Administrador
     */
    public function store(Request $request, CadastrarEmpresaAction $action): RedirectResponse
    {
        // Sanitiza CNPJ, CPF e telefones antes da validação
        $request->merge([
            'cnpj' => preg_replace('/\D/', '', (string) $request->input('cnpj')),
            'rh_cpf' => preg_replace('/\D/', '', (string) $request->input('rh_cpf')),
            'rh_telefone' => preg_replace('/\D/', '', (string) $request->input('rh_telefone')),
            'telefone' => preg_replace('/\D/', '', (string) $request->input('telefone')),
            'cep' => preg_replace('/\D/', '', (string) $request->input('cep')),
        ]);

        $validated = $request->validate([
            // Dados da Empresa
            'cnpj' => ['required', 'string', new Cnpj, 'unique:empresas,cnpj'],
            'razao_social' => ['required', 'string', 'min:3', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'situacao_cadastral' => ['nullable', 'string'],
            'ramo_atividade' => ['nullable', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'site' => ['nullable', 'string', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email_contato' => ['nullable', 'string', 'email:rfc,filter', 'max:255'],
            'cep' => ['nullable', 'string', 'max:10'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'size:2'],
            'portais' => ['nullable', 'array'],
            'portais.*' => ['integer', 'exists:portais,id'],

            // Dados do RH Master / Admin
            'rh_nome' => ['required', 'string', 'min:3', 'max:255'],
            'rh_email' => ['required', 'string', 'email:rfc,filter', 'max:255', 'unique:users,email'],
            'rh_cpf' => ['required', 'string', new Cpf, 'unique:users,cpf'],
            'rh_telefone' => ['required', 'string', new \App\Rules\CelularWhatsapp],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'cnpj.required' => 'Informe o CNPJ da empresa.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado no sistema. Faça login.',
            'razao_social.required' => 'Informe a Razão Social da empresa.',
            'cidade.required' => 'Informe a cidade da sede da empresa.',
            'estado.required' => 'Informe a UF.',
            'rh_nome.required' => 'Informe o nome do responsável pelo RH.',
            'rh_email.required' => 'Informe o e-mail corporativo do responsável.',
            'rh_email.unique' => 'Este e-mail já está em uso na plataforma.',
            'rh_cpf.required' => 'Informe o CPF do responsável.',
            'rh_cpf.unique' => 'Este CPF já está cadastrado na plataforma.',
            'rh_telefone.required' => 'Informe o celular com WhatsApp do responsável.',
            'password.required' => 'Crie uma senha de acesso.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        $resultado = $action->execute($validated);
        Auth::login($resultado['user']);

        return redirect()->route('empresa.dashboard')
            ->with('success', 'Empresa e conta de RH cadastradas com sucesso! Bem-vindo ao painel.');
    }

    /**
     * Tela de Login da Empresa
     */
    public function login(): View
    {
        return view('empresa.login');
    }

    /**
     * Autenticação da Empresa (por E-mail ou CNPJ)
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Informe seu e-mail corporativo ou CNPJ.',
            'password.required' => 'Informe sua senha.',
        ]);

        $loginInput = trim($credentials['login']);
        $user = null;

        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', strtolower($loginInput))->first();
        } else {
            // Tenta localizar por CNPJ da empresa vinculado ao usuário
            $cnpjLimpo = preg_replace('/\D/', '', $loginInput);
            $empresa = Empresa::where('cnpj', $cnpjLimpo)->first();
            if ($empresa) {
                $empresaUser = EmpresaUser::where('empresa_id', $empresa->id)
                    ->where('role', 'admin')
                    ->first();
                if ($empresaUser) {
                    $user = $empresaUser->user;
                }
            }

            // Se não encontrou por CNPJ, tenta CPF do usuário
            if (!$user && strlen($cnpjLimpo) === 11) {
                $user = User::where('cpf', $cnpjLimpo)->first();
            }
        }

        if ($user && in_array($user->tipo_usuario, ['empresa', 'prefeitura', 'admin'])) {
            if (\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();
                return redirect()->intended(route('empresa.dashboard'));
            }
        }

        return back()->withErrors([
            'login' => 'Credenciais de acesso incorretas ou conta corporativa não encontrada.',
        ])->onlyInput('login');
    }

    /**
     * Dashboard / Painel do RH
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::with(['empresa.portais'])->where('user_id', $user->id)->first();
        $empresa = $colaborador?->empresa;

        if (!$empresa) {
            abort(403, 'Usuário não possui vínculo ativo com nenhuma empresa cadastrada.');
        }

        $vagasCount = Vaga::where('empresa_id', $empresa->id)->count();
        $vagasAbertasCount = Vaga::where('empresa_id', $empresa->id)->where('status', 'publicada')->count();
        $candidaturasCount = Candidatura::whereHas('vaga', fn($q) => $q->where('empresa_id', $empresa->id))->count();
        $novosCandidatosCount = Candidatura::whereHas('vaga', fn($q) => $q->where('empresa_id', $empresa->id))
            ->where('status_etapa', 'inscrito')
            ->count();

        $ultimasVagas = Vaga::where('empresa_id', $empresa->id)
            ->withCount('candidaturas')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('empresa.dashboard', compact(
            'empresa',
            'colaborador',
            'vagasCount',
            'vagasAbertasCount',
            'candidaturasCount',
            'novosCandidatosCount',
            'ultimasVagas'
        ));
    }

    /**
     * Listagem de Vagas da Empresa
     */
    public function vagas(): View
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();
        $empresa = $colaborador->empresa;

        $vagas = Vaga::where('empresa_id', $empresa->id)
            ->with(['portal'])
            ->withCount('candidaturas')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('empresa.vagas.index', compact('empresa', 'colaborador', 'vagas'));
    }

    /**
     * Tela de Nova Vaga
     */
    public function novaVaga(): View
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();
        $empresa = $colaborador->empresa;

        // Portais em que a empresa pode publicar
        $portais = $empresa->portais()->where('status_licenca', 'ativa')->get();
        if ($portais->isEmpty()) {
            $portais = Portal::where('status_licenca', 'ativa')->get();
        }

        return view('empresa.vagas.create', compact('empresa', 'colaborador', 'portais'));
    }

    /**
     * Salva uma Nova Vaga com Perguntas Eliminatórias
     */
    public function salvarVaga(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();
        $empresa = $colaborador->empresa;

        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:255'],
            'portal_id' => ['required', 'exists:portais,id'],
            'tipo_contrato' => ['required', 'in:CLT,PJ,Estágio,Temporário,Jovem Aprendiz,Freelancer'],
            'modalidade' => ['required', 'in:Presencial,Híbrido,Remoto'],
            'escolaridade_minima' => ['nullable', 'string'],
            'experiencia' => ['nullable', 'string'],
            'faixa_salarial_min' => ['nullable', 'numeric', 'min:0'],
            'faixa_salarial_max' => ['nullable', 'numeric', 'gte:faixa_salarial_min'],
            'salario_a_combinar' => ['nullable', 'boolean'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'size:2'],
            'pcd' => ['nullable', 'boolean'],
            'confidencial' => ['nullable', 'boolean'],
            'descricao' => ['required', 'string', 'min:20'],
            'requisitos' => ['nullable', 'string'],
            'beneficios' => ['nullable', 'string'],

            // Perguntas eliminatórias de triagem
            'perguntas' => ['nullable', 'array'],
            'perguntas.*.pergunta' => ['required', 'string'],
            'perguntas.*.tipo' => ['required', 'in:sim_nao,texto'],
            'perguntas.*.obrigatoria' => ['nullable', 'boolean'],
            'perguntas.*.resposta_eliminatoria' => ['nullable', 'string'],
        ], [
            'titulo.required' => 'Informe o título da vaga.',
            'portal_id.required' => 'Selecione a cidade / prefeitura parceira.',
            'descricao.required' => 'Descreva as responsabilidades e atribuições da vaga.',
            'descricao.min' => 'A descrição deve ter no mínimo 20 caracteres.',
            'cidade.required' => 'Informe a cidade da vaga.',
            'estado.required' => 'Informe a UF.',
        ]);

        DB::transaction(function () use ($validated, $empresa, $user, $request) {
            $slug = Str::slug($validated['titulo']) . '-' . Str::random(6);

            $vaga = Vaga::create([
                'portal_id' => $validated['portal_id'],
                'empresa_id' => $empresa->id,
                'recrutador_id' => $user->id,
                'titulo' => $validated['titulo'],
                'slug' => $slug,
                'descricao' => $validated['descricao'],
                'requisitos' => $validated['requisitos'] ?? null,
                'beneficios' => $validated['beneficios'] ?? null,
                'experiencia' => $validated['experiencia'] ?? null,
                'escolaridade_minima' => $validated['escolaridade_minima'] ?? null,
                'faixa_salarial_min' => $validated['faixa_salarial_min'] ?? null,
                'faixa_salarial_max' => $validated['faixa_salarial_max'] ?? null,
                'salario_a_combinar' => $request->boolean('salario_a_combinar'),
                'tipo_contrato' => $validated['tipo_contrato'],
                'modalidade' => $validated['modalidade'],
                'pcd' => $request->boolean('pcd'),
                'cidade' => $validated['cidade'],
                'estado' => strtoupper($validated['estado']),
                'confidencial' => $request->boolean('confidencial'),
                'status' => 'publicada',
                'publicada_em' => now(),
            ]);

            // Salva perguntas de triagem se enviadas
            if (!empty($validated['perguntas'])) {
                foreach ($validated['perguntas'] as $index => $item) {
                    if (!empty($item['pergunta'])) {
                        PerguntaVaga::create([
                            'vaga_id' => $vaga->id,
                            'pergunta' => $item['pergunta'],
                            'tipo_resposta' => $item['tipo'],
                            'obrigatoria' => !empty($item['obrigatoria']),
                            'resposta_eliminatoria' => $item['resposta_eliminatoria'] ?? null,
                            'ordem' => $index + 1,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('empresa.vagas')
            ->with('success', 'Vaga publicada com sucesso e já está disponível para os candidatos!');
    }

    /**
     * Visualização de Candidatos da Vaga (Funil / Kanban)
     */
    public function vagaCandidatos(Vaga $vaga): View
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();

        if ($vaga->empresa_id !== $colaborador->empresa_id) {
            abort(403);
        }

        $candidaturas = Candidatura::with(['candidato.user', 'candidato.experiencias', 'candidato.formacoes', 'respostasTriagem.pergunta'])
            ->where('vaga_id', $vaga->id)
            ->orderByDesc('score_compatibilidade')
            ->orderByDesc('created_at')
            ->get();

        // Agrupamento por etapas do funil
        $etapas = [
            'inscrito' => $candidaturas->where('status_etapa', 'inscrito'),
            'triagem' => $candidaturas->where('status_etapa', 'triagem'),
            'entrevista' => $candidaturas->where('status_etapa', 'entrevista'),
            'aprovado' => $candidaturas->where('status_etapa', 'aprovado'),
            'contratado' => $candidaturas->where('status_etapa', 'contratado'),
            'reprovado' => $candidaturas->where('status_etapa', 'reprovado'),
        ];

        return view('empresa.vagas.candidatos', [
            'empresa' => $colaborador->empresa,
            'colaborador' => $colaborador,
            'vaga' => $vaga,
            'etapas' => $etapas,
            'totalCandidatos' => $candidaturas->count(),
        ]);
    }

    /**
     * Atualiza a etapa do candidato no funil
     */
    public function atualizarEtapaCandidatura(Request $request, Candidatura $candidatura): JsonResponse
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();

        if ($candidatura->vaga->empresa_id !== $colaborador->empresa_id) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $request->validate([
            'etapa' => ['required', 'in:inscrito,triagem,entrevista,aprovado,contratado,reprovado'],
            'motivo_rejeicao' => ['nullable', 'string', 'max:255'],
        ]);

        $candidatura->update([
            'status_etapa' => $request->input('etapa'),
            'motivo_rejeicao' => $request->input('motivo_rejeicao'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Etapa atualizada com sucesso!',
        ]);
    }

    /**
     * Gestão de Equipe e Sub-RHs (RBAC)
     */
    public function equipe(): View
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();
        $empresa = $colaborador->empresa;

        $membros = EmpresaUser::with('user')
            ->where('empresa_id', $empresa->id)
            ->get();

        $convites = ConviteEquipe::where('empresa_id', $empresa->id)
            ->whereNull('aceito_em')
            ->where('expira_em', '>', now())
            ->get();

        return view('empresa.equipe', compact('empresa', 'colaborador', 'membros', 'convites'));
    }

    /**
     * Convidar novo colaborador / Sub-RH
     */
    public function convidarMembro(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $colaborador = EmpresaUser::where('user_id', $user->id)->firstOrFail();

        if (!$colaborador->isAdmin()) {
            abort(403, 'Apenas administradores podem convidar membros para a equipe.');
        }

        $validated = $request->validate([
            'email' => ['required', 'email:rfc,filter'],
            'role' => ['required', 'in:admin,gestor_vagas,recrutador,entrevistador'],
        ], [
            'email.required' => 'Informe o e-mail do colaborador.',
            'role.required' => 'Selecione o papel do colaborador.',
        ]);

        ConviteEquipe::create([
            'empresa_id' => $colaborador->empresa_id,
            'portal_id' => $colaborador->portal_id,
            'convidado_por' => $user->id,
            'email' => strtolower(trim($validated['email'])),
            'role' => $validated['role'],
            'token' => Str::random(40),
            'expira_em' => now()->addDays(7),
        ]);

        return back()->with('success', 'Convite gerado e enviado para ' . $validated['email'] . ' com sucesso!');
    }

    /**
     * Logout da Empresa
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('empresa.login');
    }
}
