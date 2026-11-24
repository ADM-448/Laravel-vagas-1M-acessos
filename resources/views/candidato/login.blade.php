@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-primary-subtle text-primary fw-medium px-3 py-1 mb-2">Acesso do Candidato</span>
                <h3 class="fw-bold text-dark">Entrar no Currículo</h3>
                <p class="text-muted small">Acesse sua conta para ver suas candidaturas e atualizar seus dados profissionais.</p>
            </div>

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('candidato.login.post') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">E-mail ou CPF</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="seu.email@exemplo.com ou 000.000.000-00">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold text-secondary">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Lembrar-me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Ainda não tem conta? <a href="{{ route('candidato.cadastro') }}" class="fw-bold text-decoration-none">Cadastre-se Gratuitamente</a>
            </div>
        </div>
    </div>
</div>
@endsection
