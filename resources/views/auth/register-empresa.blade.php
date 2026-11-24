@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success fw-medium px-3 py-1 mb-2">Conta de Empresa / Recrutador</span>
                <h3 class="fw-bold text-dark">Cadastro de Empresa e RH</h3>
                <p class="text-muted small">Publique vagas gratuitas no portal de <strong>{{ $portal->nome ?? 'seu Município' }}</strong> e gerencie candidatos com agilidade.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.empresa.post') }}">
                @csrf

                <!-- SEÇÃO 1: DADOS DA EMPRESA -->
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="bi bi-building me-2 text-primary"></i>1. Dados da Empresa
                </h5>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="cnpj" class="form-label small fw-semibold text-secondary">CNPJ da Empresa</label>
                        <div class="input-group">
                            <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ old('cnpj') }}" required placeholder="00.000.000/0001-00" maxlength="18">
                            <button class="btn btn-outline-secondary" type="button" id="btnBuscarCnpj">
                                <span id="spinnerCnpj" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <i class="bi bi-search" id="iconBuscaCnpj"></i> Buscar
                            </button>
                        </div>
                        <div class="form-text small" id="msgCnpj">Digite o CNPJ para preencher os dados automaticamente.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="ramo_atividade" class="form-label small fw-semibold text-secondary">Ramo de Atividade</label>
                        <input type="text" name="ramo_atividade" id="ramo_atividade" class="form-control" value="{{ old('ramo_atividade') }}" placeholder="Ex: Tecnologia, Comércio, Serviços">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="razao_social" class="form-label small fw-semibold text-secondary">Razão Social</label>
                        <input type="text" name="razao_social" id="razao_social" class="form-control" value="{{ old('razao_social') }}" required placeholder="Nome empresarial oficial">
                    </div>
                    <div class="col-md-6">
                        <label for="nome_fantasia" class="form-label small fw-semibold text-secondary">Nome Fantasia (Como aparece nas vagas)</label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control" value="{{ old('nome_fantasia') }}" placeholder="Nome de exibição pública">
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-3">
                        <label for="cep" class="form-label small fw-semibold text-secondary">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" value="{{ old('cep') }}" placeholder="00000-000">
                    </div>
                    <div class="col-md-6">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $portal->cidade ?? '') }}" placeholder="Município">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF)</label>
                        <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="{{ old('estado', $portal->estado ?? '') }}" maxlength="2" placeholder="UF">
                    </div>
                </div>

                <!-- SEÇÃO 2: DADOS DO ADMINISTRADOR MASTER DE RH -->
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="bi bi-person-badge me-2 text-primary"></i>2. Responsável pelo RH (Acesso Master)
                </h5>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="nome_rh" class="form-label small fw-semibold text-secondary">Nome Completo do Gestor</label>
                        <input type="text" name="nome_rh" id="nome_rh" class="form-control" value="{{ old('nome_rh') }}" required placeholder="Ex: Roberto Alencar">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone_rh" class="form-label small fw-semibold text-secondary">Telefone / WhatsApp de Contato</label>
                        <input type="text" name="telefone_rh" id="telefone_rh" class="form-control" value="{{ old('telefone_rh') }}" placeholder="(00) 00000-0000">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email_rh" class="form-label small fw-semibold text-secondary">E-mail Corporativo do RH</label>
                    <input type="email" name="email_rh" id="email_rh" class="form-control" value="{{ old('email_rh') }}" required placeholder="rh@suaempresa.com.br">
                    <div class="form-text small">Será o login de acesso master da empresa. Depois você poderá convidar outros recrutadores (Sub-RHs).</div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-semibold text-secondary">Crie uma Senha de Acesso</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Mínimo 8 dígitos">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirme a Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita a senha">
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 py-2 fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Cadastrar Empresa e Liberar Painel
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Já é cadastrado? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Acessar Painel</a> &bull; 
                É um candidato? <a href="{{ route('register.candidato') }}" class="fw-bold text-decoration-none">Cadastro de Candidato</a>
            </div>
        </div>
    </div>
</div>

<!-- Script de Autocompletar CNPJ em Tempo Real -->
<script>
document.getElementById('btnBuscarCnpj').addEventListener('click', function() {
    const cnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
    if (cnpj.length !== 14) {
        alert('Por favor, informe um CNPJ válido com 14 dígitos.');
        return;
    }

    const spinner = document.getElementById('spinnerCnpj');
    const icon = document.getElementById('iconBuscaCnpj');
    const msg = document.getElementById('msgCnpj');

    spinner.classList.remove('d-none');
    icon.classList.add('d-none');
    msg.innerText = 'Consultando situação na Receita Federal...';
    msg.className = 'form-text small text-primary';

    fetch('/api/consulta-cnpj/' + cnpj)
        .then(response => response.json())
        .then(data => {
            if (data.valido) {
                if (data.razao_social) document.getElementById('razao_social').value = data.razao_social;
                if (data.nome_fantasia) document.getElementById('nome_fantasia').value = data.nome_fantasia;
                if (data.cidade) document.getElementById('cidade').value = data.cidade;
                if (data.estado) document.getElementById('estado').value = data.estado;
                if (data.cep) document.getElementById('cep').value = data.cep;
                if (data.ramo_atividade) document.getElementById('ramo_atividade').value = data.ramo_atividade;

                msg.innerText = 'CNPJ Ativo na Receita Federal! Dados preenchidos com sucesso.';
                msg.className = 'form-text small text-success fw-bold';
            } else {
                msg.innerText = 'Não foi possível preencher automaticamente. Você pode preencher manualmente.';
                msg.className = 'form-text small text-muted';
            }
        })
        .catch(err => {
            msg.innerText = 'Consulta automática indisponível. Preencha os campos manualmente.';
            msg.className = 'form-text small text-muted';
        })
        .finally(() => {
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');
        });
});
</script>
@endsection
