<div class="card p-3 mb-2 border-0 shadow-sm rounded-3 bg-white" id="card_candidatura_{{ $candidatura->id }}">
    <div class="d-flex justify-content-between align-items-start mb-1">
        <strong class="text-dark small">{{ $candidatura->candidato->user->name }}</strong>
        @if($candidatura->score_compatibilidade > 0)
            <span class="badge bg-success-subtle text-success border border-success-subtle small">
                {{ $candidatura->score_compatibilidade }}%
            </span>
        @endif
    </div>

    <div class="small text-muted mb-2">
        <i class="bi bi-geo-alt"></i> {{ $candidatura->candidato->cidade ?? 'Não informada' }} &bull;
        <i class="bi bi-telephone"></i> {{ $candidatura->candidato->user->telefone }}
    </div>

    <!-- Experiência mais recente -->
    @php
        $ultExp = $candidatura->candidato->experiencias->first();
    @endphp
    @if($ultExp)
        <div class="bg-light p-2 rounded mb-2 small">
            <strong>{{ $ultExp->cargo }}</strong> em {{ $ultExp->empresa }}
        </div>
    @endif

    <!-- Seletor de Movimentação de Etapa -->
    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
        <select class="form-select form-select-sm" onchange="moverEtapa({{ $candidatura->id }}, this.value)">
            <option value="inscrito" {{ $candidatura->status_etapa == 'inscrito' ? 'selected' : '' }}>Inscrito</option>
            <option value="triagem" {{ $candidatura->status_etapa == 'triagem' ? 'selected' : '' }}>Triagem</option>
            <option value="entrevista" {{ $candidatura->status_etapa == 'entrevista' ? 'selected' : '' }}>Entrevista</option>
            <option value="aprovado" {{ $candidatura->status_etapa == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
            <option value="contratado" {{ $candidatura->status_etapa == 'contratado' ? 'selected' : '' }}>Contratado</option>
            <option value="reprovado" {{ $candidatura->status_etapa == 'reprovado' ? 'selected' : '' }}>Reprovado</option>
        </select>
    </div>
</div>
