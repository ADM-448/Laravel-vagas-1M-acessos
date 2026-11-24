<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acessar com IntalenTi ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-sso {
            max-width: 440px;
            width: 100%;
            border: none;
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <div class="card card-sso shadow-lg p-4 bg-white m-3">
        <div class="text-center mb-4">
            @if(isset($portal) && $portal->brasao_url)
                <img src="{{ $portal->brasao_url }}" alt="Brasão" height="50" class="mb-2">
            @endif
            
            <h4 class="fw-bold text-dark mb-1">
                {{ $portal->nome ?? 'IntalenTi ID' }}
            </h4>
            <span class="badge bg-primary-subtle text-primary fw-medium px-2 py-1 small">
                <i class="bi bi-shield-lock-fill me-1"></i> Acesso Seguro Centralizado
            </span>
            <p class="text-muted small mt-2">
                Utilize sua conta única válida para todas as prefeituras e empresas credenciadas.
            </p>
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

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="hidden" name="portal" value="{{ $portal->slug ?? '' }}">
            <input type="hidden" name="return_to" value="{{ $returnTo }}">

            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-secondary">E-mail ou CPF</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="seu.email@exemplo.com">
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
                <a href="#" class="small text-decoration-none">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Entrar com Conta Única
            </button>
        </form>

        <hr class="my-4 text-muted opacity-25">

        <div class="text-center small text-muted">
            Ainda não tem conta? <a href="#" class="fw-bold text-decoration-none">Cadastre-se Gratuitamente</a>
        </div>
    </div>
</body>
</html>
