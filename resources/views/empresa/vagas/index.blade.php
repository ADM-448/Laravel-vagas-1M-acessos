@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Gestão de Vagas</h3>
            <p class="text-muted small mb-0">Acompanhe e gerencie as oportunidades publicadas pela sua empresa.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('empresa.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Painel Geral
            </a>
            <a href="{{ route('empresa.vagas.create') }}" class="btn btn-success btn-sm fw-semibold shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Nova Vaga
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        @if($vagas->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-briefcase text-muted" style="font-size: 3rem;"></i>
                <h5 class="fw-semibold text-secondary mt-3">Nenhuma vaga cadastrada</h5>
                <p class="text-muted small">Crie sua primeira vaga para receber currículos dos munícipes.</p>
                <a href="{{ route('empresa.vagas.create') }}" class="btn btn-success fw-semibold">
                    Publicar Vaga Agora
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Título da Oportunidade</th>
                            <th>Portal Municipal</th>
                            <th>Regime / Modalidade</th>
                            <th>Salário</th>
                            <th>Candidatos</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vagas as $vaga)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $vaga->titulo }}</div>
                                    <small class="text-muted">Publicada em {{ $vaga->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $vaga->portal?->cidade ?? $vaga->cidade }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">{{ $vaga->tipo_contrato }}</span>
                                    <span class="badge bg-info-subtle text-info">{{ $vaga->modalidade }}</span>
                                </td>
                                <td>
                                    @if($vaga->salario_a_combinar)
                                        <span class="small text-muted">A combinar</span>
                                    @elseif($vaga->faixa_salarial_min)
                                        <span class="small text-success fw-semibold">R$ {{ number_format($vaga->faixa_salarial_min, 2, ',', '.') }}</span>
                                    @else
                                        <span class="small text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('empresa.vagas.candidatos', $vaga) }}" class="badge bg-primary text-decoration-none px-3 py-2 rounded-pill">
                                        <i class="bi bi-people-fill me-1"></i> {{ $vaga->candidaturas_count }}
                                    </a>
                                </td>
                                <td>
                                    @if($vaga->status === 'publicada')
                                        <span class="badge bg-success-subtle text-success">Publicada</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($vaga->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('empresa.vagas.candidatos', $vaga) }}" class="btn btn-sm btn-primary fw-semibold">
                                        <i class="bi bi-kanban me-1"></i> Ver Pipeline
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
