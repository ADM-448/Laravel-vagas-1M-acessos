@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-primary-subtle text-primary fw-medium px-3 py-1 mb-2">Conta de Candidato</span>
                <h3 class="fw-bold text-dark">Cadastre-se Gratuitamente</h3>
                <p class="text-muted small">Crie seu <strong>IntalenTi ID</strong> para concorrer a vagas em todas as prefeituras e empresas parceiras.</p>
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

            <form method="POST" action="{{ route('register.candidato.post') }}">
                @csrf
                <input type="hidden" name="return_to" value="{{ $returnTo }}">

                <div class="mb-3">
                    <label for="name" class="form-label small fw-semibold text-secondary">Nome Completo</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Ex: Maria dos Santos">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="cpf" class="form-label small fw-semibold text-secondary">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf') }}" required placeholder="000.000.000-00" maxlength="14">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label small fw-semibold text-secondary">Celular / WhatsApp</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">Seu E-mail Principal</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="seu.email@exemplo.com">
                    <div class="form-text small">Enviaremos a confirmação para este e-mail.</div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-8">
                        <label for="cidade" class="form-label small fw-semibold text-secondary">Cidade Atual</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $portal->cidade ?? '') }}" placeholder="Sua cidade">
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label small fw-semibold text-secondary">Estado (UF)</label>
                        <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="{{ old('estado', $portal->estado ?? '') }}" maxlength="2" placeholder="UF">
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-semibold text-secondary">Crie sua Senha</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Mínimo 8 dígitos">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirme a Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita a senha">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i> Concluir Cadastro Gratuito
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center small text-muted">
                Já tem uma conta? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Faça Login</a> &bull; 
                É uma Empresa? <a href="{{ route('register.empresa') }}" class="fw-bold text-decoration-none">Cadastre sua Empresa</a>
            </div>
        </div>
    </div>
</div>
@endsection
