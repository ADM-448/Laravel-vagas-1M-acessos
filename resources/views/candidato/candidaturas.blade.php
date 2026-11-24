@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h3 class="fw-bold text-dark"><i class="bi bi-briefcase me-2 text-primary"></i>Minhas Candidaturas</h3>
        <p class="text-muted">Acompanhe em tempo real o avanço dos seus processos seletivos.</p>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Vaga / Oportunidade</th>
                            <th>Empresa</th>
                            <th>Data de Inscrição</th>
                            <th>Status no Processo</th>
                            <th class="text-end pe-4">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidaturas as $candidatura)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $candidatura->vaga->titulo }}</div>
                                    <small class="text-muted">{{ $candidatura->vaga->cidade }}/{{ $candidatura->vaga->estado }} &bull; {{ ucfirst($candidatura->vaga->modalidade) }}</small>
                                </td>
                                <td>
                                    <span class="text-secondary fw-medium">
                                        {{ $candidatura->vaga->confidencial ? 'Empresa Confidencial' : ($candidatura->vaga->empresa->nome_fantasia ?? $candidatura->vaga->empresa->razao_social) }}
                                    </span>
                                </td>
                                <td>{{ $candidatura->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $badgeClasses = [
                                            'inscrito' => 'bg-info-subtle text-info',
                                            'triagem' => 'bg-primary-subtle text-primary',
                                            'entrevista' => 'bg-warning-subtle text-warning-emphasis',
                                            'proposta' => 'bg-success-subtle text-success',
                                            'aprovado' => 'bg-success text-white',
                                            'reprovado' => 'bg-danger-subtle text-danger',
                                            'banco_reserva' => 'bg-secondary-subtle text-secondary',
                                        ];
                                        $etapaLabels = [
                                            'inscrito' => 'Inscrição Recebida',
                                            'triagem' => 'Em Análise de Triagem',
                                            'entrevista' => 'Etapa de Entrevista',
                                            'proposta' => 'Proposta Enviada',
                                            'aprovado' => 'Aprovado / Contratado',
                                            'reprovado' => 'Não Selecionado',
                                            'banco_reserva' => 'Banco de Talentos',
                                        ];
                                    @endphp
                                    <span class="badge {{ $badgeClasses[$candidatura->etapa_pipeline] ?? 'bg-light text-dark' }} px-3 py-2">
                                        {{ $etapaLabels[$candidatura->etapa_pipeline] ?? ucfirst($candidatura->etapa_pipeline) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('vagas.show', $candidatura->vaga_id) }}" class="btn btn-outline-secondary btn-sm">
                                        Ver Vaga
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Você ainda não se candidatou a nenhuma vaga.
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
