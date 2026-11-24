@extends('layouts.app')

@section('content')
<div class="container py-2">
    <!-- CABEÇALHO DO PAINEL -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 bg-white p-4 rounded-4 shadow-sm border">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h3 class="fw-bold text-dark mb-0">{{ $empresa->nome_fantasia ?: $empresa->razao_social }}</h3>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                    <i class="bi bi-patch-check-fill me-1"></i> CNPJ Ativo: {{ $empresa->cnpj }}
                </span>
            </div>
            <p class="text-muted small mb-0">
                <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $empresa->cidade }} - {{ $empresa->estado }} &bull; 
                Papel: <strong>{{ strtoupper($colaborador->role) }}</strong> &bull;
                Portais Municipais: 
                @foreach($empresa->portais as $p)
                    <span class="badge bg-light text-dark border">{{ $p->cidade }}</span>
                @endforeach
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('empresa.vagas.create') }}" class="btn btn-success fw-semibold shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Publicar Nova Vaga
            </a>
            <a href="{{ route('empresa.equipe') }}" class="btn btn-outline-secondary fw-semibold">
                <i class="bi bi-people me-1"></i> Equipe (RH)
            </a>
        </div>
    </div>

    <!-- CARDS DE MÉTRICAS -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">VAGAS ATIVAS</span>
                    <span class="rounded bg-primary-subtle text-primary p-2 d-inline-flex"><i class="bi bi-briefcase-fill fs-5"></i></span>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $vagasAbertasCount }}</h2>
                <small class="text-muted">de {{ $vagasCount }} vagas no total</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">CANDIDATURAS</span>
                    <span class="rounded bg-info-subtle text-info p-2 d-inline-flex"><i class="bi bi-file-earmark-person-fill fs-5"></i></span>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $candidaturasCount }}</h2>
                <small class="text-muted">currículos recebidos</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">NOVOS EM TRIAGEM</span>
                    <span class="rounded bg-warning-subtle text-warning p-2 d-inline-flex"><i class="bi bi-hourglass-split fs-5"></i></span>
                </div>
                <h2 class="fw-bold text-warning mb-0">{{ $novosCandidatosCount }}</h2>
                <small class="text-muted">aguardando análise do RH</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">MUNICÍPIOS ATIVOS</span>
                    <span class="rounded bg-success-subtle text-success p-2 d-inline-flex"><i class="bi bi-buildings-fill fs-5"></i></span>
                </div>
                <h2 class="fw-bold text-success mb-0">{{ $empresa->portais->count() }}</h2>
                <small class="text-muted">prefeituras conveniadas</small>
            </div>
        </div>
    </div>

    <!-- ÚLTIMAS VAGAS PUBLICADAS -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-task me-1 text-primary"></i> Vagas Recentes e Pipeline</h5>
            <a href="{{ route('empresa.vagas') }}" class="btn btn-sm btn-outline-primary fw-semibold">Ver Todas as Vagas</a>
        </div>

        @if($ultimasVagas->isEmpty())
            <div class="text-center py-5 bg-light rounded-3">
                <i class="bi bi-folder-plus text-muted" style="font-size: 3rem;"></i>
                <h6 class="fw-semibold text-secondary mt-3">Sua empresa ainda não publicou nenhuma vaga</h6>
                <p class="text-muted small mb-3">Divulgue suas oportunidades de trabalho diretamente para os candidatos da região.</p>
                <a href="{{ route('empresa.vagas.create') }}" class="btn btn-success fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Criar Primeira Vaga
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Vaga</th>
                            <th class="border-0">Regime / Modalidade</th>
                            <th class="border-0">Município</th>
                            <th class="border-0">Candidatos</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimasVagas as $vaga)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $vaga->titulo }}</div>
                                    <small class="text-muted">Publicada em {{ $vaga->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">{{ $vaga->tipo_contrato }}</span>
                                    <span class="badge bg-info-subtle text-info">{{ $vaga->modalidade }}</span>
                                </td>
                                <td>
                                    <span class="small fw-medium">{{ $vaga->cidade }}/{{ $vaga->estado }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('empresa.vagas.candidatos', $vaga) }}" class="badge bg-primary text-decoration-none px-3 py-2 rounded-pill">
                                        <i class="bi bi-people-fill me-1"></i> {{ $vaga->candidaturas_count }} candidatos
                                    </a>
                                </td>
                                <td>
                                    @if($vaga->status === 'publicada')
                                        <span class="badge bg-success-subtle text-success">Ativa</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($vaga->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('empresa.vagas.candidatos', $vaga) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                        <i class="bi bi-kanban me-1"></i> Funil de Candidatos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
