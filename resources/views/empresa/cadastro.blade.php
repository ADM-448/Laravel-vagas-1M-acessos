@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success fw-medium px-3 py-1 mb-2">
                    <i class="bi bi-building-check me-1"></i> Portal Corporativo
                </span>
                <h3 class="fw-bold text-dark">Cadastro de Empresa Parceira</h3>
                <p class="text-muted small">Cadastre sua empresa com CNPJ ativo para publicar vagas diretamente nos portais das prefeituras parceiras e receber talentos qualificados.</p>
            </div>

            <form method="POST" action="{{ route('empresa.cadastro.post') }}" id="formCadastroEmpresa" novalidate>
                @csrf

                <!-- SEÇÃO 1: DADOS DA EMPRESA E CNPJ -->
                <div class="border-start border-primary border-4 ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">1. Dados Cadastrais da Empresa</h5>
                    <small class="text-muted">Informe o CNPJ para busca automática dos dados na Receita Federal.</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="cnpj" class="form-label small fw-semibold text-secondary">CNPJ da Empresa *</label>
                        <div class="input-group">
                            <input type="text" name="cnpj" id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" value="{{ old('cnpj') }}" required placeholder="00.000.000/0000-00" maxlength="18" autocomplete="off" autofocus>
                            <button class="btn btn-outline-primary" type="button" id="btnBuscarCnpj" onclick="consultarCnpjReceita()">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                        <div id="cnpjFeedback" class="small mt-1 d-none"></div>
                        @error('cnpj')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="situacao_cadastral" class="form-label small fw-semibold text-secondary">Situação Cadastral</label>
                        <input type="text" name="situacao_cadastral" id="situacao_cadastral" class="form-control bg-light" value="{{ old('situacao_cadastral', 'ATIVA') }}" readonly>
                    </div>

                    <div class="col-md-7">
                        <label for="razao_social" class="form-label small fw-semibold text-secondary">Razão Social *</label>
                        <input type="text" name="razao_social" id="razao_social" class="form-control @error('razao_social') is-invalid @enderror" value="{{ old('razao_social') }}" required placeholder="Ex: Silva & Santos Tecnologia LTDA">
                        @error('razao_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="nome_fantasia" class="form-label small fw-semibold text-secondary">Nome Fantasia</label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control" value="{{ old('nome_fantasia') }}" placeholder="Ex: Tech Talentos">
                    </div>

                    <div class="col-md-8">
                        <label for="ramo_atividade" class="form-label small fw-semibold text-secondary">Ramo de Atividade / CNAE</label>
                        <input type="text" name="ramo_atividade" id="ramo_atividade" class="form-control" value="{{ old('ramo_atividade') }}" placeholder="Ex: Desenvolvimento de Softwares, Comércio Varejista...">
                    </div>

                    <div class="col-md-4">
                        <label for="telefone" class="form-label small fw-semibold text-secondary">Telefone da Empresa</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone') }}" placeholder="(00) 0000-0000">
                    </div>
                </div>

                <!-- ENDEREÇO DA EMPRESA -->
                <div class="row g-2 mb-4 bg-light p-3 rounded-3 border">
                    <div class="col-md-3">
                        <label for="cep" class="form-label small fw-semibold text-secondary">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control form-control-sm" value="{{ old('cep') }}" placeholder="00000-000" maxlength="9">
                    </div>
                    <div class="col-md-6">
                        <label for="logradouro" class="form-label small fw-semibold text-secondary">Logradouro / Rua</label>
                        <input type="text" name="logradouro" id="logradouro" class="form-control form-control-sm" value="{{ old('logradouro') }}" placeholder="Avenida Brasil">
                    </div>
                    <div class="col-md-3">
                        <label for="numero" class="form-label small fw-semibold text-secondary">Número</label>
                        <input type="text" name="numero" id="numero" class="form-control form-control-sm" value="{{ old('numero') }}" placeholder="123">
                    </div>
                    <div class="col-md-4">
                        <label for="bairro" class="form-label small fw-semibold text-secondary">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control form-control-sm" value="{{ old('bairro') }}" placeholder="Centro">
                    </div>
                    <div class="col-md-5">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Cidade *</label>
                        <input type="text" name="cidade" id="cidade" class="form-control form-control-sm @error('cidade') is-invalid @enderror" value="{{ old('cidade', 'Santos') }}" required placeholder="Ex: Santos">
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF) *</label>
                        <input type="text" name="estado" id="estado" class="form-control form-control-sm text-uppercase @error('estado') is-invalid @enderror" value="{{ old('estado', 'SP') }}" required maxlength="2" placeholder="SP">
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- SEÇÃO 2: MUNICÍPIOS / PREFEITURAS PARCEIRAS -->
                <div class="border-start border-success border-4 ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">2. Prefeituras e Portais de Vagas</h5>
                    <small class="text-muted">Selecione onde sua empresa deseja atuar e divulgar vagas para os munícipes.</small>
                </div>

                <div class="mb-4 p-3 bg-light rounded-3 border">
                    <label class="form-label small fw-semibold text-secondary d-block mb-2">Portais Municipais Cadastrados:</label>
                    <div class="row g-2">
                        @foreach($portais as $portal)
                            <div class="col-md-6">
                                <div class="form-check card p-2 border-0 shadow-sm h-100 flex-row align-items-center">
                                    <input class="form-check-input ms-1 me-2" type="checkbox" name="portais[]" value="{{ $portal->id }}" id="portal_{{ $portal->id }}" checked>
                                    <label class="form-check-label w-100 cursor-pointer" for="portal_{{ $portal->id }}">
                                        <strong>{{ $portal->cidade }} ({{ $portal->estado }})</strong><br>
                                        <small class="text-muted">{{ $portal->nome }}</small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- SEÇÃO 3: DADOS DO RESPONSÁVEL (RH MASTER / ADMIN) -->
                <div class="border-start border-warning border-4 ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">3. Dados do Gestor do RH (Administrador)</h5>
                    <small class="text-muted">Acesso inicial que poderá gerenciar vagas e convidar outros recrutadores e entrevistadores.</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="rh_nome" class="form-label small fw-semibold text-secondary">Nome Completo do Gestor *</label>
                        <input type="text" name="rh_nome" id="rh_nome" class="form-control @error('rh_nome') is-invalid @enderror" value="{{ old('rh_nome') }}" required placeholder="Ex: Amanda Ferreira">
                        @error('rh_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="rh_email" class="form-label small fw-semibold text-secondary">E-mail Corporativo *</label>
                        <input type="email" name="rh_email" id="rh_email" class="form-control @error('rh_email') is-invalid @enderror" value="{{ old('rh_email') }}" required placeholder="amanda@empresa.com.br">
                        @error('rh_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="rh_cpf" class="form-label small fw-semibold text-secondary">CPF do Gestor *</label>
                        <input type="text" name="rh_cpf" id="rh_cpf" class="form-control @error('rh_cpf') is-invalid @enderror" value="{{ old('rh_cpf') }}" required placeholder="000.000.000-00" maxlength="14" autocomplete="off">
                        <div id="rhCpfFeedback" class="small mt-1 d-none"></div>
                        @error('rh_cpf')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="rh_telefone" class="form-label small fw-semibold text-secondary">Celular / WhatsApp *</label>
                        <input type="text" name="rh_telefone" id="rh_telefone" class="form-control @error('rh_telefone') is-invalid @enderror" value="{{ old('rh_telefone') }}" required placeholder="(00) 90000-0000" maxlength="15" autocomplete="off">
                        @error('rh_telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-semibold text-secondary">Crie uma Senha *</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Mínimo 6 dígitos">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirme a Senha *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita a senha">
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-semibold mt-3" id="btnSubmitEmpresa">
                    <i class="bi bi-check-circle-fill me-1"></i> Concluir Cadastro e Acessar Painel do RH
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Sua empresa já possui cadastro? <a href="{{ route('empresa.login') }}" class="fw-bold text-decoration-none">Acessar Painel</a>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS DE MÁSCARA E CONSULTA DE CNPJ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputCnpj = document.getElementById('cnpj');
    const cnpjFeedback = document.getElementById('cnpjFeedback');
    const inputRhCpf = document.getElementById('rh_cpf');
    const inputRhTel = document.getElementById('rh_telefone');

    // Máscara de CNPJ: 00.000.000/0000-00
    inputCnpj.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 14) v = v.slice(0, 14);

        if (v.length > 12) {
            e.target.value = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        } else if (v.length > 8) {
            e.target.value = v.replace(/(\d{2})(\d{3})(\d{3})(\d{1,4})/, "$1.$2.$3/$4");
        } else if (v.length > 5) {
            e.target.value = v.replace(/(\d{2})(\d{3})(\d{1,3})/, "$1.$2.$3");
        } else if (v.length > 2) {
            e.target.value = v.replace(/(\d{2})(\d{1,3})/, "$1.$2");
        } else {
            e.target.value = v;
        }

        if (v.length === 14) {
            consultarCnpjReceita();
        }
    });

    // Máscara de CPF do RH
    inputRhCpf.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);
        if (v.length > 9) e.target.value = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        else if (v.length > 6) e.target.value = v.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
        else if (v.length > 3) e.target.value = v.replace(/(\d{3})(\d{1,3})/, "$1.$2");
        else e.target.value = v;
    });

    // Máscara de Celular / WhatsApp
    inputRhTel.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);
        if (v.length > 10) e.target.value = v.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
        else if (v.length > 6) e.target.value = v.replace(/(\d{2})(\d{4})(\d{1,4})/, "($1) $2-$3");
        else if (v.length > 2) e.target.value = v.replace(/(\d{2})(\d{1,5})/, "($1) $2");
        else e.target.value = v;
    });
});

function consultarCnpjReceita() {
    const inputCnpj = document.getElementById('cnpj');
    const feedback = document.getElementById('cnpjFeedback');
    const btn = document.getElementById('btnBuscarCnpj');
    const cnpj = inputCnpj.value.replace(/\D/g, '');

    if (cnpj.length !== 14) {
        feedback.className = 'small mt-1 text-danger d-block';
        feedback.innerText = 'Digite o CNPJ completo com 14 dígitos.';
        return;
    }

    feedback.className = 'small mt-1 text-primary d-block';
    feedback.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Consultando dados da Receita Federal...';
    btn.disabled = true;

    fetch(`/empresa/consultar-cnpj/${cnpj}`)
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if (data.ja_cadastrado) {
                feedback.className = 'small mt-1 text-danger d-block fw-semibold';
                feedback.innerHTML = `⚠️ ${data.message}`;
                return;
            }

            if (data.success && data.origem === 'receita') {
                feedback.className = 'small mt-1 text-success d-block fw-semibold';
                feedback.innerHTML = `✅ Dados encontrados na Receita Federal (${data.situacao_cadastral})`;

                if (data.razao_social) document.getElementById('razao_social').value = data.razao_social;
                if (data.nome_fantasia) document.getElementById('nome_fantasia').value = data.nome_fantasia;
                if (data.situacao_cadastral) document.getElementById('situacao_cadastral').value = data.situacao_cadastral;
                if (data.ramo_atividade) document.getElementById('ramo_atividade').value = data.ramo_atividade;
                if (data.telefone) document.getElementById('telefone').value = data.telefone;
                if (data.cep) document.getElementById('cep').value = data.cep;
                if (data.logradouro) document.getElementById('logradouro').value = data.logradouro;
                if (data.numero) document.getElementById('numero').value = data.numero;
                if (data.complemento) document.getElementById('complemento').value = data.complemento;
                if (data.bairro) document.getElementById('bairro').value = data.bairro;
                if (data.cidade) document.getElementById('cidade').value = data.cidade;
                if (data.estado) document.getElementById('estado').value = data.estado;
            } else {
                feedback.className = 'small mt-1 text-muted d-block';
                feedback.innerText = 'Não encontramos na base automática. Preencha os dados manualmente.';
            }
        })
        .catch(() => {
            btn.disabled = false;
            feedback.className = 'small mt-1 text-muted d-block';
            feedback.innerText = 'Preencha os campos abaixo manualmente.';
        });
}
</script>
@endsection
