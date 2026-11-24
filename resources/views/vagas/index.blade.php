@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center py-4 bg-white rounded-3 shadow-sm border">
        <h2 class="fw-bold text-dark mb-2">Oportunidades de Emprego em {{ $portal->cidade ?? 'sua Região' }}</h2>
        <p class="text-muted">Encontre sua próxima vaga de trabalho conectando-se diretamente às empresas locais.</p>
        
        <!-- Formulário de Filtro de Alta Performance -->
        <form method="GET" action="{{ route('vagas.index') }}" class="row g-2 justify-content-center mt-3 px-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="busca" value="{{ $busca }}" class="form-control" placeholder="Cargo, habilidade ou palavra-chave...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="modalidade" class="form-select">
                    <option value="">Todas as Modalidades</option>
                    <option value="presencial" {{ $modalidade == 'presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="hibrido" {{ $modalidade == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                    <option value="remoto" {{ $modalidade == 'remoto' ? 'selected' : '' }}>Remoto</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-portal w-100 fw-semibold">
                    Filtrar Vagas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Listagem de Vagas -->
<div class="row g-3">
    @forelse($vagas as $vaga)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-shadow transition">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary-subtle text-secondary text-uppercase px-2 py-1 small">
                            {{ $vaga->tipo_contrato }}
                        </span>
                        @if($vaga->destaque)
                            <span class="badge badge-destaque px-2 py-1 small">
                                <i class="bi bi-star-fill text-dark me-1"></i> Destaque
                            </span>
                        @endif
                    </div>

                    <h5 class="card-title fw-bold text-primary mb-1">
                        <a href="{{ route('vagas.show', $vaga->id) }}" class="text-decoration-none text-dark stretched-link">
                            {{ $vaga->titulo }}
                        </a>
                    </h5>

                    <p class="text-muted small mb-2">
                        <i class="bi bi-building me-1"></i>
                        {{ $vaga->confidencial ? 'Empresa Confidencial' : ($vaga->empresa->nome_fantasia ?? $vaga->empresa->razao_social) }}
                    </p>

                    <p class="card-text text-secondary small flex-grow-1">
                        {{ \Illuminate\Support\Str::limit($vaga->descricao, 110) }}
                    </p>

                    <hr class="my-2 text-muted opacity-25">

                    <div class="d-flex justify-content-between align-items-center text-muted small mt-auto">
                        <span><i class="bi bi-geo-alt me-1"></i> {{ $vaga->cidade }}/{{ $vaga->estado }} ({{ ucfirst($vaga->modalidade) }})</span>
                        @if($vaga->faixa_salarial_min)
                            <span class="fw-bold text-success">
                                R$ {{ number_format($vaga->faixa_salarial_min, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-muted">A combinar</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <h5 class="mt-3 text-secondary">Nenhuma vaga encontrada no momento.</h5>
            <p class="text-muted">Tente ajustar seus termos de pesquisa ou volte mais tarde.</p>
        </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $vagas->links() }}
</div>
@endsection
