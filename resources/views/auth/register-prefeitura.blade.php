@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-warning-subtle text-warning-emphasis fw-medium px-3 py-1 mb-2">Prefeituras & Órgãos Públicos</span>
                <h3 class="fw-bold text-dark">Credenciamento de Novo Município</h3>
                <p class="text-muted small">Configure o portal oficial de empregos da prefeitura com domínio próprio e observatório econômico.</p>
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

            <form method="POST" action="{{ route('register.prefeitura.post') }}">
                @csrf

                <!-- SEÇÃO 1: DADOS DO MUNICÍPIO / PORTAL -->
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="bi bi-geo-alt-fill me-2 text-primary"></i>1. Dados do Município
                </h5>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Nome do Município</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade') }}" required placeholder="Ex: Santos">
                    </div>
                    <div class="col-md-2">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF)</label>
                        <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="{{ old('estado') }}" required maxlength="2" placeholder="SP">
                    </div>
                    <div class="col-md-4">
                        <label for="ibge_code" class="form-label small fw-semibold text-secondary">Código IBGE (Opcional)</label>
                        <input type="text" name="ibge_code" id="ibge_code" class="form-control" value="{{ old('ibge_code') }}" maxlength="7" placeholder="Ex: 3548500">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="dominio_principal" class="form-label small fw-semibold text-secondary">Domínio Oficial Desejado (Opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">https://</span>
                        <input type="text" name="dominio_principal" id="dominio_principal" class="form-control" value="{{ old('dominio_principal') }}" placeholder="vagas.seumunicipio.sp.gov.br">
                    </div>
                    <div class="form-text small">Caso não tenha domínio próprio agora, geraremos um subdomínio padrão temporário.</div>
                </div>

                <!-- SEÇÃO 2: DADOS DO GESTOR DA PREFEITURA -->
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="bi bi-person-check-fill me-2 text-primary"></i>2. Gestor Responsável pela Prefeitura
                </h5>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="nome_gestor" class="form-label small fw-semibold text-secondary">Nome do Gestor / Secretário</label>
                        <input type="text" name="nome_gestor" id="nome_gestor" class="form-control" value="{{ old('nome_gestor') }}" required placeholder="Ex: Ana Beatriz Lima">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone_gestor" class="form-label small fw-semibold text-secondary">Telefone / WhatsApp Institucional</label>
                        <input type="text" name="telefone_gestor" id="telefone_gestor" class="form-control" value="{{ old('telefone_gestor') }}" placeholder="(00) 00000-0000">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email_gestor" class="form-label small fw-semibold text-secondary">E-mail Institucional (@gov.br)</label>
                    <input type="email" name="email_gestor" id="email_gestor" class="form-control" value="{{ old('email_gestor') }}" required placeholder="gestor@seumunicipio.sp.gov.br">
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-semibold text-secondary">Crie uma Senha Master</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Mínimo 8 dígitos">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirme a Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita a senha">
                    </div>
                </div>

                <button type="submit" class="btn btn-warning btn-lg w-100 py-2 fw-semibold">
                    <i class="bi bi-shield-check me-1"></i> Ativar Portal da Prefeitura e Abrir Observatório
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
