@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success fw-medium px-3 py-1 mb-2">
                    <i class="bi bi-shield-lock-fill me-1"></i> Área da Empresa
                </span>
                <h3 class="fw-bold text-dark">Entrar no Painel do RH</h3>
                <p class="text-muted small">Gerencie suas vagas, triagem de candidatos e equipe de recrutamento.</p>
            </div>

            <form method="POST" action="{{ route('empresa.login.post') }}" novalidate>
                @csrf

                <!-- E-mail ou CNPJ -->
                <div class="mb-3">
                    <label for="login" class="form-label small fw-semibold text-secondary">E-mail Corporativo ou CNPJ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                        <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" required placeholder="exemplo@empresa.com ou CNPJ" autofocus>
                    </div>
                    @error('login')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Senha -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label small fw-semibold text-secondary mb-0">Sua Senha</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Digite sua senha">
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-secondary" for="remember">Lembrar este dispositivo</label>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Acessar Painel do RH
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Sua empresa ainda não é parceira? <a href="{{ route('empresa.cadastro') }}" class="fw-bold text-success text-decoration-none">Cadastre-se Gratuitamente</a>
            </div>
        </div>
    </div>
</div>
@endsection
