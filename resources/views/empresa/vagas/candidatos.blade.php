@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <!-- CABEÇALHO DO KANBAN / PIPELINE -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 bg-white p-3 rounded-4 shadow-sm border">
        <div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('empresa.vagas') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h4 class="fw-bold text-dark mb-0">{{ $vaga->titulo }}</h4>
                <span class="badge bg-primary-subtle text-primary">{{ $vaga->tipo_contrato }}</span>
                <span class="badge bg-secondary-subtle text-secondary">{{ $vaga->cidade }}/{{ $vaga->estado }}</span>
            </div>
            <small class="text-muted ms-4 ps-2">Pipeline de Seleção &bull; <strong>{{ $totalCandidatos }}</strong> candidatos inscritos</small>
        </div>

        <div class="d-flex gap-2">
            <span class="badge bg-light text-dark border p-2 d-flex align-items-center gap-1">
                <i class="bi bi-funnel-fill text-primary"></i> Filtrar por Compatibilidade
            </span>
        </div>
    </div>

    <!-- COLUNAS DO FUNIL DE CONTRATAÇÃO (KANBAN) -->
    <div class="row g-3 flex-nowrap overflow-auto pb-4" style="min-height: 70vh;">
        <!-- ETAPA: INSCRITOS -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-inbox me-1"></i> Inscritos</h6>
                    <span class="badge bg-secondary rounded-pill">{{ $etapas['inscrito']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-inscrito">
                    @forelse($etapas['inscrito'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ETAPA: TRIAGEM -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-warning mb-0"><i class="bi bi-filter-circle me-1"></i> Em Triagem</h6>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $etapas['triagem']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-triagem">
                    @forelse($etapas['triagem'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ETAPA: ENTREVISTA -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-primary mb-0"><i class="bi bi-chat-dots me-1"></i> Entrevista</h6>
                    <span class="badge bg-primary rounded-pill">{{ $etapas['entrevista']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-entrevista">
                    @forelse($etapas['entrevista'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ETAPA: APROVADO -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-info mb-0"><i class="bi bi-hand-thumbs-up me-1"></i> Aprovados</h6>
                    <span class="badge bg-info text-white rounded-pill">{{ $etapas['aprovado']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-aprovado">
                    @forelse($etapas['aprovado'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ETAPA: CONTRATADO -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-success mb-0"><i class="bi bi-check-circle-fill me-1"></i> Contratados</h6>
                    <span class="badge bg-success rounded-pill">{{ $etapas['contratado']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-contratado">
                    @forelse($etapas['contratado'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ETAPA: REPROVADO -->
        <div class="col-12 col-md-4 col-lg-3 col-xl-2" style="min-width: 270px;">
            <div class="bg-light p-3 rounded-4 border h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-danger mb-0"><i class="bi bi-x-circle me-1"></i> Reprovados</h6>
                    <span class="badge bg-danger rounded-pill">{{ $etapas['reprovado']->count() }}</span>
                </div>
                <div class="flex-grow-1 overflow-auto" id="coluna-reprovado">
                    @forelse($etapas['reprovado'] as $c)
                        @include('empresa.vagas._card_candidato', ['candidatura' => $c])
                    @empty
                        <div class="text-center py-4 text-muted small">Nenhum candidato nesta fase</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function moverEtapa(candidaturaId, novaEtapa) {
    fetch(`/empresa/candidaturas/${candidaturaId}/etapa`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ etapa: novaEtapa })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Erro ao mover candidato.');
        }
    })
    .catch(() => alert('Erro de conexão ao mover etapa.'));
}
</script>
@endsection
