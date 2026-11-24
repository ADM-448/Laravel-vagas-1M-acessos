@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-primary-subtle text-primary fw-medium px-3 py-1 mb-2">Portal do Candidato</span>
                <h3 class="fw-bold text-dark">Cadastro de Currículo Único</h3>
                <p class="text-muted small">Crie sua conta para concorrer a vagas em todas as prefeituras e empresas parceiras com um só cadastro.</p>
            </div>

            <form method="POST" action="{{ route('candidato.cadastro.post') }}" novalidate>
                @csrf

                <!-- Nome Completo -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-semibold text-secondary">Nome Completo *</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ex: Roberto Carlos da Silva" autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-2 mb-3">
                    <!-- CPF com Máscara e Validador -->
                    <div class="col-md-6">
                        <label for="cpf" class="form-label small fw-semibold text-secondary">CPF *</label>
                        <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror" value="{{ old('cpf') }}" required placeholder="000.000.000-00" maxlength="14" autocomplete="off">
                        <div id="cpfFeedback" class="small mt-1 d-none"></div>
                        @error('cpf')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Celular / WhatsApp com Máscara e Validador -->
                    <div class="col-md-6">
                        <label for="telefone" class="form-label small fw-semibold text-secondary">Celular / WhatsApp *</label>
                        <input type="text" name="telefone" id="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone') }}" required placeholder="(00) 90000-0000" maxlength="15" autocomplete="off">
                        <div id="telefoneFeedback" class="small mt-1 d-none"></div>
                        @error('telefone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- E-mail Principal -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">Seu E-mail Principal *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="seu.nome@exemplo.com">
                    </div>
                    <div id="emailFeedback" class="small mt-1 d-none"></div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Você usará este e-mail (ou seu CPF) para acessar sua conta.</div>
                </div>

                <!-- Município / Região Parceira Selecionável -->
                <div class="mb-3">
                    <label for="selectRegiao" class="form-label small fw-semibold text-secondary">Sua Região / Município *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                        <select id="selectRegiao" class="form-select" onchange="atualizarLocalidade(this.value)">
                            <option value="">-- Selecione um Município / Região Cadastrada --</option>
                            @foreach($portais as $portal)
                                <option value="{{ $portal->cidade }}|{{ $portal->estado }}" {{ old('cidade') == $portal->cidade ? 'selected' : '' }}>
                                    {{ $portal->cidade }} ({{ $portal->estado }}) &bull; {{ $portal->nome }}
                                </option>
                            @endforeach
                            <option value="outro" {{ old('select_outro') ? 'selected' : '' }}>Outro Município (Não listado)...</option>
                        </select>
                    </div>
                    <div class="form-text small">Selecione seu município para ter acesso às vagas locais da sua prefeitura.</div>
                </div>

                <!-- Campos de Cidade e Estado (Preenchidos automaticamente ou abertos se "Outro") -->
                <div class="row g-2 mb-3 d-none" id="divCamposManuais">
                    <div class="col-md-8">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Nome da Cidade *</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $portais->first()?->cidade ?? 'Santos') }}" placeholder="Ex: Santos">
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF) *</label>
                        <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="{{ old('estado', $portais->first()?->estado ?? 'SP') }}" maxlength="2" placeholder="SP">
                    </div>
                </div>

                <!-- Senhas -->
                <div class="row g-2 mb-4">
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

                <button type="submit" class="btn btn-primary btn-lg w-100 py-2 fw-semibold" id="btnSubmit">
                    <i class="bi bi-person-check-fill me-1"></i> Criar Conta e Acessar Currículo
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Já possui cadastro? <a href="{{ route('candidato.login') }}" class="fw-bold text-decoration-none">Entrar na Conta</a>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS DE MÁSCARA E VALIDAÇÃO EM TEMPO REAL -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputCpf = document.getElementById('cpf');
    const cpfFeedback = document.getElementById('cpfFeedback');
    
    const inputTel = document.getElementById('telefone');
    const telFeedback = document.getElementById('telefoneFeedback');

    const inputEmail = document.getElementById('email');
    const emailFeedback = document.getElementById('emailFeedback');

    // 1. MÁSCARA E VALIDAÇÃO DE CPF EM TEMPO REAL
    inputCpf.addEventListener('input', function (e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);

        if (v.length > 9) {
            e.target.value = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        } else if (v.length > 6) {
            e.target.value = v.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
        } else if (v.length > 3) {
            e.target.value = v.replace(/(\d{3})(\d{1,3})/, "$1.$2");
        } else {
            e.target.value = v;
        }

        // Validação quando completou 11 dígitos
        if (v.length === 11) {
            if (validarCPF(v)) {
                inputCpf.classList.remove('is-invalid');
                inputCpf.classList.add('is-valid');
                cpfFeedback.classList.remove('d-none', 'text-danger');
                cpfFeedback.classList.add('text-success');
                cpfFeedback.innerText = '✓ CPF válido';
            } else {
                inputCpf.classList.remove('is-valid');
                inputCpf.classList.add('is-invalid');
                cpfFeedback.classList.remove('d-none', 'text-success');
                cpfFeedback.classList.add('text-danger');
                cpfFeedback.innerText = '✗ CPF inválido (dígitos verificadores incorretos)';
            }
        } else {
            inputCpf.classList.remove('is-valid', 'is-invalid');
            cpfFeedback.classList.add('d-none');
        }
    });

    // Função de validação matemática oficial de CPF
    function validarCPF(cpf) {
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        let soma = 0, resto;
        for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(9, 10))) return false;
        soma = 0;
        for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(10, 11))) return false;
        return true;
    }

    // 2. MÁSCARA E VALIDAÇÃO DE CELULAR / WHATSAPP EM TEMPO REAL
    inputTel.addEventListener('input', function (e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);

        if (v.length > 10) {
            e.target.value = v.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
        } else if (v.length > 6) {
            e.target.value = v.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
        } else if (v.length > 2) {
            e.target.value = v.replace(/(\d{2})(\d{0,5})/, "($1) $2");
        } else {
            e.target.value = v;
        }

        // Validação quando completou 11 dígitos
        if (v.length === 11) {
            const ddd = parseInt(v.substring(0, 2));
            const nonoDigito = v.charAt(2);
            const todosIguais = /^(\d)\1{10}$/.test(v);

            if (nonoDigito === '9' && !todosIguais && ddd >= 11 && ddd <= 99) {
                inputTel.classList.remove('is-invalid');
                inputTel.classList.add('is-valid');
                telFeedback.classList.remove('d-none', 'text-danger');
                telFeedback.classList.add('text-success');
                telFeedback.innerText = '✓ Número de WhatsApp válido';
            } else {
                inputTel.classList.remove('is-valid');
                inputTel.classList.add('is-invalid');
                telFeedback.classList.remove('d-none', 'text-success');
                telFeedback.classList.add('text-danger');
                telFeedback.innerText = '✗ Celular deve ter DDD válido e iniciar com 9';
            }
        } else {
            inputTel.classList.remove('is-valid', 'is-invalid');
            telFeedback.classList.add('d-none');
        }
    });

    // 3. VALIDAÇÃO DE E-MAIL EM TEMPO REAL
    inputEmail.addEventListener('blur', function (e) {
        const email = e.target.value.trim();
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email.length > 0) {
            if (regexEmail.test(email)) {
                inputEmail.classList.remove('is-invalid');
                inputEmail.classList.add('is-valid');
                emailFeedback.classList.add('d-none');
            } else {
                inputEmail.classList.remove('is-valid');
                inputEmail.classList.add('is-invalid');
                emailFeedback.classList.remove('d-none', 'text-success');
                emailFeedback.classList.add('text-danger');
                emailFeedback.innerText = '✗ Formato de e-mail inválido. Ex: nome@gmail.com';
            }
        } else {
            inputEmail.classList.remove('is-valid', 'is-invalid');
            emailFeedback.classList.add('d-none');
        }
    });

    // 4. INICIALIZAÇÃO DA LOCALIDADE
    const selectRegiao = document.getElementById('selectRegiao');
    if (selectRegiao && selectRegiao.value) {
        atualizarLocalidade(selectRegiao.value);
    }
});

function atualizarLocalidade(val) {
    const divManuais = document.getElementById('divCamposManuais');
    const inputCidade = document.getElementById('cidade');
    const inputEstado = document.getElementById('estado');

    if (!val) {
        divManuais.classList.add('d-none');
        inputCidade.value = '';
        inputEstado.value = '';
        return;
    }

    if (val === 'outro') {
        divManuais.classList.remove('d-none');
        inputCidade.value = '';
        inputEstado.value = '';
        inputCidade.focus();
    } else {
        divManuais.classList.add('d-none');
        const partes = val.split('|');
        inputCidade.value = partes[0] || '';
        inputEstado.value = partes[1] || '';
    }
}
</script>
@endsection
