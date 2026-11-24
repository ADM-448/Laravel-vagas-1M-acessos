@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Cabeçalho -->
    <div class="col-12 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Meu Currículo Digital</h3>
            <p class="text-muted mb-0">Seu currículo é compartilhado automaticamente com todas as prefeituras parceiras onde você se candidatar.</p>
        </div>
        <div>
            <a href="{{ route('candidato.candidaturas') }}" class="btn btn-outline-primary fw-semibold">
                <i class="bi bi-briefcase me-1"></i> Ver Minhas Candidaturas
            </a>
        </div>
    </div>

    <!-- Coluna Esquerda: Cartão de Perfil & Dados Pessoais -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center sticky-top" style="top: 85px;">
            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem;">
                <i class="bi bi-person-fill"></i>
            </div>
            <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <span class="badge bg-success-subtle text-success px-3 py-1 mb-3">
                <i class="bi bi-shield-check me-1"></i> Conta Unificada Ativa
            </span>

            <div class="text-start small text-muted border-top pt-3">
                <div class="mb-2"><i class="bi bi-person-vcard text-primary me-2"></i>CPF: <strong>{{ $user->cpf }}</strong></div>
                <div class="mb-2"><i class="bi bi-whatsapp text-success me-2"></i>Celular: <strong>{{ $user->telefone ?: 'Não informado' }}</strong></div>
                <div class="mb-2"><i class="bi bi-geo-alt text-danger me-2"></i>Localidade: <strong>{{ $candidato->cidade ?: 'Não informada' }}/{{ $candidato->estado ?: '' }}</strong></div>
                @if($candidato->pretensao_salarial)
                    <div class="mb-2"><i class="bi bi-cash text-success me-2"></i>Pretensão: <strong>R$ {{ number_format($candidato->pretensao_salarial, 2, ',', '.') }}</strong></div>
                @endif
                @if($candidato->linkedin_url)
                    <div class="mb-2"><i class="bi bi-linkedin text-primary me-2"></i><a href="{{ $candidato->linkedin_url }}" target="_blank" class="text-decoration-none">Perfil no LinkedIn</a></div>
                @endif
                @if($candidato->pcd)
                    <div class="mt-2"><span class="badge bg-info-subtle text-info"><i class="bi bi-universal-access me-1"></i> Profissional PCD</span></div>
                @endif
            </div>

            @if($candidato->resumo_profissional)
                <div class="text-start border-top pt-3 mt-3">
                    <span class="fw-bold small text-dark d-block mb-1">Sobre mim:</span>
                    <p class="text-secondary small mb-0">{{ $candidato->resumo_profissional }}</p>
                </div>
            @endif

            <div class="d-grid mt-4">
                <button class="btn btn-outline-primary btn-sm py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEditarDados">
                    <i class="bi bi-pencil-square me-1"></i> Editar Dados Pessoais
                </button>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Seções do Currículo -->
    <div class="col-lg-8">
        <!-- SEÇÃO 1: EXPERIÊNCIAS PROFISSIONAIS -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-briefcase-fill me-2 text-primary"></i>Experiências Profissionais</h5>
                <button class="btn btn-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddExperiencia">
                    <i class="bi bi-plus-lg me-1"></i> Adicionar Experiência
                </button>
            </div>

            @forelse($candidato->experiencias as $exp)
                <div class="p-3 bg-light rounded-3 mb-3 border position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold text-dark mb-1">{{ $exp->cargo }}</h6>
                            <div class="text-muted small">
                                <strong>{{ $exp->empresa }}</strong> &bull; 
                                {{ $exp->data_inicio->format('m/Y') }} até {{ $exp->atual ? 'o momento' : $exp->data_fim?->format('m/Y') }}
                                @if($exp->atual)
                                    <span class="badge bg-success-subtle text-success ms-1">Atual</span>
                                @endif
                            </div>
                        </div>
                        <form method="POST" action="{{ route('candidato.experiencia.delete', $exp->id) }}" onsubmit="return confirm('Deseja excluir esta experiência?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    @if($exp->descricao_atividades)
                        <p class="text-secondary small mt-2 mb-0">{{ $exp->descricao_atividades }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-briefcase fs-3 d-block mb-1"></i>
                    Nenhuma experiência profissional cadastrada ainda.
                </div>
            @endforelse
        </div>

        <!-- SEÇÃO 2: FORMAÇÃO ACADÊMICA -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-mortarboard-fill me-2 text-success"></i>Formação Acadêmica</h5>
                <button class="btn btn-success btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddFormacao">
                    <i class="bi bi-plus-lg me-1"></i> Adicionar Formação
                </button>
            </div>

            @forelse($candidato->formacoes as $formacao)
                <div class="p-3 bg-light rounded-3 mb-3 border position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold text-dark mb-1">{{ $formacao->curso }}</h6>
                            <div class="text-muted small">
                                <strong>{{ $formacao->instituicao }}</strong> &bull; 
                                {{ ucfirst(str_replace('_', ' ', $formacao->grau)) }} &bull;
                                Status: <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($formacao->status) }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('candidato.formacao.delete', $formacao->id) }}" onsubmit="return confirm('Deseja excluir esta formação?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-mortarboard fs-3 d-block mb-1"></i>
                    Nenhuma formação acadêmica cadastrada ainda.
                </div>
            @endforelse
        </div>

        <!-- SEÇÃO 3: CURSOS E CERTIFICAÇÕES -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-award-fill me-2 text-warning"></i>Cursos & Habilidades</h5>
                <button class="btn btn-warning btn-sm fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#modalAddCurso">
                    <i class="bi bi-plus-lg me-1"></i> Adicionar Curso
                </button>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @forelse($candidato->cursos as $curso)
                    <div class="bg-light border rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 small">
                        <strong>{{ $curso->titulo }}</strong>
                        @if($curso->carga_horaria)
                            <span class="text-muted">({{ $curso->carga_horaria }}h)</span>
                        @endif
                        <form method="POST" action="{{ route('candidato.curso.delete', $curso->id) }}" class="d-inline" onsubmit="return confirm('Deseja remover este curso?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0 ms-1" style="font-size: 0.85rem;"><i class="bi bi-x-circle"></i></button>
                        </form>
                    </div>
                @empty
                    <div class="col-12 text-center py-3 text-muted">
                        Nenhum curso ou certificação adicionada.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: EDITAR DADOS PESSOAIS -->
<div class="modal fade" id="modalEditarDados" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <form method="POST" action="{{ route('candidato.dados.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Editar Dados Pessoais & Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nome Completo</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Celular / WhatsApp</label>
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $user->telefone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control" value="{{ old('data_nascimento', $candidato->data_nascimento?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Gênero</label>
                            <select name="genero" class="form-select">
                                <option value="nao_informar" {{ $candidato->genero == 'nao_informar' ? 'selected' : '' }}>Prefiro não informar</option>
                                <option value="masculino" {{ $candidato->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino" {{ $candidato->genero == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="outro" {{ $candidato->genero == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Pretensão Salarial (R$)</label>
                            <input type="number" step="0.01" name="pretensao_salarial" class="form-control" value="{{ old('pretensao_salarial', $candidato->pretensao_salarial) }}" placeholder="Ex: 3500.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="{{ old('cidade', $candidato->cidade) }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Estado (UF)</label>
                            <input type="text" name="estado" class="form-control text-uppercase" maxlength="2" value="{{ old('estado', $candidato->estado) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Perfil no LinkedIn</label>
                            <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $candidato->linkedin_url) }}" placeholder="https://linkedin.com/in/...">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="pcd" value="1" class="form-check-input" id="checkPcd" {{ $candidato->pcd ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold" for="checkPcd">Sou pessoa com deficiência (PCD)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Resumo Profissional (Apresente-se aos recrutadores)</label>
                            <textarea name="resumo_profissional" rows="3" class="form-control" placeholder="Conte um pouco sobre suas habilidades, trajetória e objetivos...">{{ old('resumo_profissional', $candidato->resumo_profissional) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: ADICIONAR EXPERIÊNCIA -->
<div class="modal fade" id="modalAddExperiencia" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form method="POST" action="{{ route('candidato.experiencia.add') }}">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Adicionar Experiência Profissional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Cargo / Função</label>
                        <input type="text" name="cargo" class="form-control" required placeholder="Ex: Analista Financeiro">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Empresa</label>
                        <input type="text" name="empresa" class="form-control" required placeholder="Nome da empresa">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Data de Início</label>
                            <input type="date" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Data de Término</label>
                            <input type="date" name="data_fim" class="form-control" id="inputDataFim">
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="atual" value="1" class="form-check-input" id="checkAtual" onchange="document.getElementById('inputDataFim').disabled = this.checked;">
                        <label class="form-check-label small" for="checkAtual">Trabalho atualmente nesta empresa</label>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Principais Atividades</label>
                        <textarea name="descricao_atividades" rows="2" class="form-control" placeholder="Descreva brevemente suas atribuições..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Salvar Experiência</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: ADICIONAR FORMAÇÃO -->
<div class="modal fade" id="modalAddFormacao" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form method="POST" action="{{ route('candidato.formacao.add') }}">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Adicionar Formação Acadêmica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Curso</label>
                        <input type="text" name="curso" class="form-control" required placeholder="Ex: Administração de Empresas">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Instituição de Ensino</label>
                        <input type="text" name="instituicao" class="form-control" required placeholder="Ex: USP, UNIP, Fatec...">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Nível / Grau</label>
                            <select name="grau" class="form-select" required>
                                <option value="ensino_medio">Ensino Médio</option>
                                <option value="tecnico">Técnico</option>
                                <option value="superior_incompleto">Superior Incompleto</option>
                                <option value="superior_completo" selected>Superior Completo</option>
                                <option value="pos_graduacao">Pós-Graduação / MBA</option>
                                <option value="mestrado">Mestrado</option>
                                <option value="doutorado">Doutorado</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="completo">Completo</option>
                                <option value="cursando">Cursando</option>
                                <option value="interrompido">Interrompido</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Ano / Mês de Início</label>
                            <input type="date" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Previsão / Conclusão</label>
                            <input type="date" name="data_fim" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success fw-semibold">Salvar Formação</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 4: ADICIONAR CURSO -->
<div class="modal fade" id="modalAddCurso" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form method="POST" action="{{ route('candidato.curso.add') }}">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Adicionar Curso ou Certificação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nome do Curso / Habilidade</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ex: Excel Avançado, Inglês Intermediário...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Instituição Emissora (Opcional)</label>
                        <input type="text" name="instituicao" class="form-control" placeholder="Ex: SENAI, Alura, Coursera...">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Carga Horária (Horas)</label>
                            <input type="number" name="carga_horaria" class="form-control" placeholder="Ex: 40">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Ano de Conclusão</label>
                            <input type="number" name="ano_conclusao" class="form-control" value="{{ date('Y') }}" min="1980" max="{{ date('Y') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-semibold text-dark">Salvar Curso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
