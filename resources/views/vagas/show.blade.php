@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary text-uppercase me-2">{{ $vaga->tipo_contrato }}</span>
                    <span class="badge bg-secondary-subtle text-secondary me-2">{{ ucfirst($vaga->modalidade) }}</span>
                    @if($vaga->destaque)
                        <span class="badge badge-destaque"><i class="bi bi-star-fill me-1"></i> Destaque</span>
                    @endif
                    <h2 class="fw-bold text-dark mt-2 mb-1">{{ $vaga->titulo }}</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-building me-1"></i>
                        {{ $vaga->confidencial ? 'Empresa Confidencial' : ($vaga->empresa->nome_fantasia ?? $vaga->empresa->razao_social) }}
                        &bull; <i class="bi bi-geo-alt ms-2 me-1"></i> {{ $vaga->cidade }}/{{ $vaga->estado }}
                    </p>
                </div>
                
                @if($vaga->faixa_salarial_min)
                    <div class="text-end">
                        <span class="text-muted small d-block">Faixa Salarial</span>
                        <h4 class="fw-bold text-success mb-0">
                            R$ {{ number_format($vaga->faixa_salarial_min, 2, ',', '.') }}
                            @if($vaga->faixa_salarial_max)
                                - {{ number_format($vaga->faixa_salarial_max, 2, ',', '.') }}
                            @endif
                        </h4>
                    </div>
                @endif
            </div>

            <hr class="my-3">

            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-2"><i class="bi bi-card-text me-2 text-primary"></i>Descrição da Oportunidade</h5>
                <p class="text-secondary lh-base" style="white-space: pre-line;">{{ $vaga->descricao }}</p>
            </div>

            @if($vaga->requisitos)
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-check2-circle me-2 text-primary"></i>Requisitos e Qualificações</h5>
                    <p class="text-secondary lh-base" style="white-space: pre-line;">{{ $vaga->requisitos }}</p>
                </div>
            @endif

            @if($vaga->beneficios)
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-gift me-2 text-primary"></i>Benefícios</h5>
                    <p class="text-secondary lh-base" style="white-space: pre-line;">{{ $vaga->beneficios }}</p>
                </div>
            @endif

            <hr class="my-4">

            <!-- Formulário de Candidatura com Triagem -->
            <div class="bg-light p-4 rounded-3 border">
                <h4 class="fw-bold text-dark mb-2">Deseja concorrer a esta vaga?</h4>
                <p class="text-muted small mb-3">Seu perfil e currículo do <strong>IntalenTi ID</strong> serão enviados diretamente aos recrutadores.</p>

                @auth
                    @if(auth()->user()->isCandidato())
                        @php
                            $jaInscrito = \App\Models\Candidatura::where('vaga_id', $vaga->id)
                                ->where('candidato_id', auth()->user()->candidato?->id)
                                ->exists();
                        @endphp

                        @if($jaInscrito)
                            <div class="alert alert-info d-flex align-items-center mb-0">
                                <i class="bi bi-check-circle-fill fs-4 me-3 text-info"></i>
                                <div>
                                    <strong>Você já está participando desta seleção!</strong>
                                    <div class="small">Acompanhe o status no menu <a href="{{ route('candidato.candidaturas') }}" class="alert-link">Minhas Candidaturas</a>.</div>
                                </div>
                            </div>
                        @else
                            <form method="POST" action="#">
                                @csrf
                                @if($vaga->perguntas->isNotEmpty())
                                    <h6 class="fw-bold text-secondary mb-3">Responda às perguntas de triagem:</h6>
                                    @foreach($vaga->perguntas as $pergunta)
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-dark">{{ $pergunta->pergunta }}</label>
                                            @if($pergunta->tipo_resposta === 'sim_nao')
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respostas[{{ $pergunta->id }}]" id="p_{{ $pergunta->id }}_sim" value="sim" required>
                                                        <label class="form-check-label" for="p_{{ $pergunta->id }}_sim">Sim</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respostas[{{ $pergunta->id }}]" id="p_{{ $pergunta->id }}_nao" value="nao" required>
                                                        <label class="form-check-label" for="p_{{ $pergunta->id }}_nao">Não</label>
                                                    </div>
                                                </div>
                                            @else
                                                <input type="text" name="respostas[{{ $pergunta->id }}]" class="form-control" required>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif

                                <button type="submit" class="btn btn-success btn-lg px-4 fw-semibold mt-2">
                                    <i class="bi bi-send-check me-2"></i> Confirmar Candidatura Gratuita
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle me-1"></i> Apenas contas de <strong>Candidato</strong> podem se inscrever nesta vaga.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login', ['portal' => $portal->slug ?? '', 'return_to' => url()->current()]) }}" class="btn btn-portal btn-lg px-4 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Entrar com IntalenTi ID para Candidatar-se
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
