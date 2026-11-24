@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-dark mb-1">Painel do RH &bull; {{ $empresa->nome_fantasia ?? $empresa->razao_social }}</h3>
            <span class="badge bg-success-subtle text-success me-2">CNPJ Válido: {{ $empresa->cnpj }}</span>
            <span class="badge bg-primary-subtle text-primary">Seu Nível: {{ ucfirst(str_replace('_', ' ', $vinculo->role)) }}</span>
        </div>
        @if($vinculo->canManageVagas())
            <a href="#" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Publicar Nova Vaga
            </a>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <span class="text-muted small fw-semibold text-uppercase">Vagas Cadastradas</span>
            <h2 class="fw-bold text-dark mb-0 mt-1">{{ $vagas->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <span class="text-muted small fw-semibold text-uppercase">Total de Candidaturas Recebidas</span>
            <h2 class="fw-bold text-primary mb-0 mt-1">{{ $vagas->sum('candidaturas_count') }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <span class="text-muted small fw-semibold text-uppercase">Visualizações Totais</span>
            <h2 class="fw-bold text-success mb-0 mt-1">{{ $vagas->sum('visualizacoes_count') }}</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Vagas da Empresa</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Título da Vaga</th>
                            <th>Modalidade</th>
                            <th>Status</th>
                            <th>Candidatos</th>
                            <th>Visualizações</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vagas as $vaga)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $vaga->titulo }}</td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($vaga->modalidade) }}</span></td>
                                <td>
                                    <span class="badge {{ $vaga->status === 'publicada' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($vaga->status) }}
                                    </span>
                                </td>
                                <td><span class="fw-bold text-primary">{{ $vaga->candidaturas_count }}</span> inscritos</td>
                                <td>{{ $vaga->visualizacoes_count }} views</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('vagas.show', $vaga->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Nenhuma vaga cadastrada por enquanto.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
