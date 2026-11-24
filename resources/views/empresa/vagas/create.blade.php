@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-2">
    <div class="col-lg-10 col-xl-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold text-dark mb-0">Publicar Nova Vaga</h3>
                <p class="text-muted small mb-0">Defina os detalhes da oportunidade e perguntas de triagem eliminatórias.</p>
            </div>
            <a href="{{ route('empresa.vagas') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Vagas
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <form method="POST" action="{{ route('empresa.vagas.store') }}" id="formNovaVaga">
                @csrf

                <!-- SEÇÃO 1: INFORMAÇÕES BÁSICAS -->
                <div class="border-start border-primary border-4 ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">1. Informações Básicas da Oportunidade</h5>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label for="titulo" class="form-label small fw-semibold text-secondary">Título do Cargo / Vaga *</label>
                        <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required placeholder="Ex: Assistente Administrativo, Desenvolvedor PHP, Analista de RH...">
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="portal_id" class="form-label small fw-semibold text-secondary">Prefeitura / Município Parceiro *</label>
                        <select name="portal_id" id="portal_id" class="form-select @error('portal_id') is-invalid @enderror" required>
                            @foreach($portais as $portal)
                                <option value="{{ $portal->id }}" {{ old('portal_id') == $portal->id ? 'selected' : '' }}>
                                    {{ $portal->cidade }} ({{ $portal->estado }})
                                </option>
                            @endforeach
                        </select>
                        @error('portal_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="tipo_contrato" class="form-label small fw-semibold text-secondary">Regime de Contratação *</label>
                        <select name="tipo_contrato" id="tipo_contrato" class="form-select" required>
                            <option value="CLT">CLT (Efetivo)</option>
                            <option value="PJ">PJ (Prestador de Serviços)</option>
                            <option value="Estágio">Estágio</option>
                            <option value="Temporário">Temporário</option>
                            <option value="Jovem Aprendiz">Jovem Aprendiz</option>
                            <option value="Freelancer">Freelancer</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="modalidade" class="form-label small fw-semibold text-secondary">Modalidade de Trabalho *</label>
                        <select name="modalidade" id="modalidade" class="form-select" required>
                            <option value="Presencial">Presencial</option>
                            <option value="Híbrido">Híbrido</option>
                            <option value="Remoto">100% Remoto</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="escolaridade_minima" class="form-label small fw-semibold text-secondary">Escolaridade Mínima</label>
                        <select name="escolaridade_minima" id="escolaridade_minima" class="form-select">
                            <option value="Ensino Fundamental">Ensino Fundamental</option>
                            <option value="Ensino Médio" selected>Ensino Médio</option>
                            <option value="Técnico">Ensino Técnico</option>
                            <option value="Superior Cursando">Superior Cursando</option>
                            <option value="Superior Completo">Superior Completo</option>
                            <option value="Pós-Graduação">Pós-Graduação / Especialização</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="faixa_salarial_min" class="form-label small fw-semibold text-secondary">Salário Mínimo (R$)</label>
                        <input type="number" step="0.01" name="faixa_salarial_min" id="faixa_salarial_min" class="form-control" value="{{ old('faixa_salarial_min') }}" placeholder="Ex: 2500.00">
                    </div>

                    <div class="col-md-4">
                        <label for="faixa_salarial_max" class="form-label small fw-semibold text-secondary">Salário Máximo (R$)</label>
                        <input type="number" step="0.01" name="faixa_salarial_max" id="faixa_salarial_max" class="form-control" value="{{ old('faixa_salarial_max') }}" placeholder="Ex: 3500.00">
                    </div>

                    <div class="col-md-4 d-flex align-items-center mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="salario_a_combinar" id="salario_a_combinar" value="1">
                            <label class="form-check-label small fw-semibold text-secondary" for="salario_a_combinar">
                                Salário a Combinar
                            </label>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Cidade da Vaga *</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $empresa->cidade) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF) *</label>
                        <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="{{ old('estado', $empresa->estado) }}" maxlength="2" required>
                    </div>

                    <div class="col-12 d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pcd" id="pcd" value="1">
                            <label class="form-check-label small text-secondary" for="pcd">
                                Vaga afirmativa para PCD (Pessoas com Deficiência)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="confidencial" id="confidencial" value="1">
                            <label class="form-check-label small text-secondary" for="confidencial">
                                Empresa Confidencial (Ocultar nome da empresa no anúncio)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SEÇÃO 2: DESCRIÇÃO, REQUISITOS E BENEFÍCIOS -->
                <div class="border-start border-success border-4 ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">2. Descrição, Requisitos e Benefícios</h5>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="descricao" class="form-label small fw-semibold text-secondary">Descrição das Atividades e Responsabilidades *</label>
                        <textarea name="descricao" id="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror" required placeholder="Descreva o que o profissional fará no dia a dia...">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="requisitos" class="form-label small fw-semibold text-secondary">Requisitos e Conhecimentos Necessários</label>
                        <textarea name="requisitos" id="requisitos" rows="3" class="form-control" placeholder="- Experiência anterior na função&#10;- Conhecimento em Pacote Office...">{{ old('requisitos') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="beneficios" class="form-label small fw-semibold text-secondary">Benefícios Oferecidos</label>
                        <textarea name="beneficios" id="beneficios" rows="3" class="form-control" placeholder="- Vale Refeição / Alimentação&#10;- Vale Transporte&#10;- Plano de Saúde...">{{ old('beneficios') }}</textarea>
                    </div>
                </div>

                <!-- SEÇÃO 3: PERGUNTAS ELIMINATÓRIAS DE TRIAGEM -->
                <div class="border-start border-warning border-4 ps-3 mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">3. Perguntas de Triagem Eliminatória</h5>
                        <small class="text-muted">Candidatos que responderem com a resposta eliminatória serão desclassificados automaticamente.</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-semibold" onclick="adicionarPerguntaTriagem()">
                        <i class="bi bi-plus-lg me-1"></i> Adicionar Pergunta
                    </button>
                </div>

                <div id="containerPerguntas" class="mb-4">
                    <!-- Perguntas dinâmicas adicionadas via JS -->
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Publicar Vaga no Portal
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let perguntaIndex = 0;

function adicionarPerguntaTriagem() {
    perguntaIndex++;
    const container = document.getElementById('containerPerguntas');
    const div = document.createElement('div');
    div.className = 'card p-3 mb-2 bg-light border';
    div.id = `pergunta_${perguntaIndex}`;

    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="text-dark small">Pergunta #${perguntaIndex}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger py-0" onclick="removerPergunta('pergunta_${perguntaIndex}')">
                <i class="bi bi-trash"></i> Remover
            </button>
        </div>
        <div class="row g-2">
            <div class="col-md-7">
                <input type="text" name="perguntas[${perguntaIndex}][pergunta]" class="form-control form-control-sm" placeholder="Ex: Você possui Carteira Nacional de Habilitação (CNH B)?" required>
            </div>
            <div class="col-md-2">
                <select name="perguntas[${perguntaIndex}][tipo]" class="form-select form-select-sm">
                    <option value="sim_nao">Sim / Não</option>
                    <option value="texto">Texto Livre</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="perguntas[${perguntaIndex}][resposta_eliminatoria]" class="form-select form-select-sm">
                    <option value="">Sem eliminação automática</option>
                    <option value="nao">Eliminar se responder "NÃO"</option>
                    <option value="sim">Eliminar se responder "SIM"</option>
                </select>
            </div>
        </div>
    `;

    container.appendChild(div);
}

function removerPergunta(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}
</script>
@endsection
