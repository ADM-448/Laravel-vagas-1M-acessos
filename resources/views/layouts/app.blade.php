<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($portalAtual->nome ?? 'IntalenTi Vagas') }}</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --cor-primaria: {{ $portalAtual->cor_primaria ?? '#0d6efd' }};
            --cor-secundaria: {{ $portalAtual->cor_secundaria ?? '#6c757d' }};
        }
        .btn-portal {
            background-color: var(--cor-primaria);
            color: #fff;
            border: none;
        }
        .btn-portal:hover {
            opacity: 0.9;
            color: #fff;
        }
        .badge-destaque {
            background-color: #ffc107;
            color: #212529;
            font-weight: 600;
        }
        .header-portal {
            border-bottom: 3px solid var(--cor-primaria);
        }
    </style>
    @livewireStyles
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark header-portal sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                @if(isset($portalAtual) && $portalAtual->brasao_url)
                    <img src="{{ $portalAtual->brasao_url }}" alt="Brasão" height="34">
                @else
                    <span class="rounded bg-primary text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-briefcase-fill"></i>
                    </span>
                @endif
                <span>{{ $portalAtual->nome ?? 'IntalenTi Vagas' }}</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Início</a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center gap-2">
                    @auth
                        @if(auth()->user()->isCandidato())
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('candidato.curriculo') }}">
                                    <i class="bi bi-file-earmark-person"></i> Meu Currículo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('candidato.candidaturas') }}">
                                    <i class="bi bi-briefcase"></i> Minhas Candidaturas
                                </a>
                            </li>
                        @elseif(auth()->user()->isEmpresa())
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('empresa.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Painel do RH
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('empresa.vagas') }}">
                                    <i class="bi bi-briefcase"></i> Vagas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('empresa.equipe') }}">
                                    <i class="bi bi-people"></i> Equipe
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-1"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="btn btn-outline-light btn-sm px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('candidato.login') }}">
                                        <i class="bi bi-person-circle text-primary me-2"></i> Sou Candidato
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('empresa.login') }}">
                                        <i class="bi bi-building text-success me-2"></i> Sou Empresa / RH
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm px-3 fw-semibold" href="{{ route('candidato.cadastro') }}">
                                <i class="bi bi-person-plus me-1"></i> Cadastrar Currículo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success btn-sm px-3 fw-semibold" href="{{ route('empresa.cadastro') }}">
                                <i class="bi bi-building-add me-1"></i> Para Empresas
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} {{ $portalAtual->nome ?? 'IntalenTi Vagas' }} &bull; Todos os direitos reservados.</span>
            <span>Tecnologia de Alta Concorrência &bull; <strong>IntalenTi ID</strong></span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
