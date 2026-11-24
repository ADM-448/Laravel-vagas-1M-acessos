@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold text-dark mb-1">
            <i class="bi bi-graph-up-arrow me-2 text-primary"></i>Observatório do Emprego &bull; {{ $portal->nome }}
        </h3>
        <p class="text-muted">Painel oficial de geração de empregos e desenvolvimento econômico do município.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary">
            <span class="text-muted small fw-semibold text-uppercase">Vagas Totais Cadastradas</span>
            <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalVagas }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success">
            <span class="text-muted small fw-semibold text-uppercase">Oportunidades Ativas Agora</span>
            <h2 class="fw-bold text-success mb-0 mt-1">{{ $vagasAtivas }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning">
            <span class="text-muted small fw-semibold text-uppercase">Empresas Credenciadas no Município</span>
            <h2 class="fw-bold text-warning-emphasis mb-0 mt-1">{{ $totalEmpresas }}</h2>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check me-2 text-success"></i>Status da Licença Municipal</h5>
    <div class="d-flex align-items-center gap-3">
        <span class="badge bg-success fs-6 px-3 py-2">Licença Ativa (SaaS)</span>
        <span class="text-muted">Cidade: <strong>{{ $portal->cidade }}/{{ $portal->estado }}</strong> &bull; IBGE: <strong>{{ $portal->ibge_code }}</strong></span>
    </div>
</div>
@endsection
