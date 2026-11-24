@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white text-center">
            <i class="bi bi-envelope-check-fill display-3 text-primary mb-3"></i>
            <h3 class="fw-bold text-dark">Confirme seu E-mail</h3>
            <p class="text-secondary">
                Obrigado por se cadastrar no <strong>IntalenTi ID</strong>! Enviamos um link de confirmação para o seu e-mail (<strong>{{ auth()->user()->email }}</strong>).
            </p>
            <p class="text-muted small">
                Por favor, clique no link recebido para ativar totalmente sua conta e liberar o envio de candidaturas e publicação de vagas.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-primary fw-semibold">
                    <i class="bi bi-arrow-repeat me-1"></i> Reenviar E-mail de Verificação
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
