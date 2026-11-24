<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntalenTi Vagas &bull; Plataforma Oficial de Empregos e Cidades</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --dark-blue: #0b192c;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .hero-section {
            background: linear-gradient(135deg, #0b192c 0%, #1e3a8a 100%);
            color: white;
            padding: 5rem 0 4rem;
        }
        .card-perfil {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            transition: all 0.25s ease;
            background: white;
        }
        .card-perfil:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }
        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
        }
        .badge-city {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }
        .badge-city:hover {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Topo / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: var(--dark-blue);">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="rounded bg-primary text-white p-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-briefcase-fill fs-5"></i>
                </span>
                <span class="fs-4">IntalenTi <span class="text-primary-emphasis fw-light">Vagas</span></span>
            </a>

            <div class="d-flex align-items-center gap-2">
                @auth
                    @if(auth()->user()->isCandidato())
                        <a href="{{ route('candidato.curriculo') }}" class="btn btn-outline-light btn-sm px-3">
                            <i class="bi bi-file-earmark-person me-1"></i> Meu Currículo
                        </a>
                    @elseif(auth()->user()->isEmpresa())
                        <a href="{{ route('empresa.dashboard') }}" class="btn btn-outline-light btn-sm px-3">
                            <i class="bi bi-speedometer2 me-1"></i> Painel do RH
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger px-3">Sair</button>
                    </form>
                @else
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-outline-light btn-sm px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </button>
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
                    </div>
                    <a href="{{ route('candidato.cadastro') }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                        <i class="bi bi-person-plus me-1"></i> Cadastrar Currículo
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Seção Hero -->
    <header class="hero-section text-center">
        <div class="container">
            <span class="badge bg-primary-subtle text-primary fw-medium px-3 py-2 rounded-pill mb-3">
                <i class="bi bi-stars me-1"></i> Conectando Municípios, Empresas e Talentos
            </span>
            <h1 class="display-5 fw-bold mb-3 text-white">
                O Futuro do Emprego e Oportunidades na Sua Cidade
            </h1>
            <p class="lead text-light text-opacity-75 mx-auto mb-4" style="max-width: 720px;">
                Uma plataforma única de alta concorrência desenhada para conectar cidadãos em busca de trabalho, empresas locais e prefeituras em um só ecossistema inteligente.
            </p>

            <!-- Seletor Rápido de Prefeituras / Cidades -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-8 col-lg-6">
                    <div class="bg-white p-2 rounded-4 shadow-lg text-start d-flex align-items-center gap-2">
                        <span class="text-muted ps-3"><i class="bi bi-search fs-5"></i></span>
                        <select class="form-select border-0 shadow-none fs-6 text-secondary py-2" id="seletorCidade" onchange="selecionarCidade(this.value)">
                            <option value="">Selecione sua Cidade / Município para ver vagas...</option>
                            @foreach($portais as $portal)
                                <option value="{{ $portal->slug }}">
                                    {{ $portal->cidade }}/{{ $portal->estado }} &bull; {{ $portal->nome }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary px-4 py-2 rounded-3 fw-semibold flex-shrink-0" onclick="irParaCidade()">
                            Acessar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Seção: Os 3 Perfis de Acesso -->
    <main class="py-5" id="perfis">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Escolha o seu perfil de acesso</h2>
                <p class="text-muted">Acesse as ferramentas dedicadas para a sua necessidade na plataforma.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- 1. Candidato -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-perfil h-100 p-4 text-center d-flex flex-column">
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto">
                            <i class="bi bi-person-vcard"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Sou Candidato</h4>
                        <p class="text-secondary small flex-grow-1">
                            Cadastre seu currículo único no <strong>IntalenTi ID</strong> gratuitamente e concorra a oportunidades de emprego em qualquer município parceiro.
                        </p>
                        <div class="d-grid gap-2 mt-4">
                            @auth
                                <a href="{{ route('candidato.curriculo') }}" class="btn btn-primary fw-semibold py-2">
                                    <i class="bi bi-file-earmark-person me-1"></i> Acessar Meu Currículo
                                </a>
                                <a href="{{ route('candidato.candidaturas') }}" class="btn btn-outline-secondary btn-sm py-2">
                                    <i class="bi bi-briefcase me-1"></i> Ver Minhas Candidaturas
                                </a>
                            @else
                                <a href="{{ route('candidato.cadastro') }}" class="btn btn-primary fw-semibold py-2">
                                    <i class="bi bi-person-plus me-1"></i> Cadastrar Meu Currículo
                                </a>
                                <a href="{{ route('candidato.login') }}" class="btn btn-outline-secondary btn-sm py-2">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Já tenho conta (Entrar)
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- 2. Empresa / RH -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-perfil h-100 p-4 text-center d-flex flex-column">
                        <div class="icon-circle bg-success-subtle text-success mx-auto">
                            <i class="bi bi-building"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Sou Empresa</h4>
                        <p class="text-secondary small flex-grow-1">
                            Publique vagas para profissionais da região, valide seu CNPJ na Receita e gerencie candidatos com triagem automatizada e equipe de Sub-RHs.
                        </p>
                        <div class="d-grid gap-2 mt-4">
                            @auth
                                @if(auth()->user()->isEmpresa())
                                    <a href="{{ route('empresa.dashboard') }}" class="btn btn-success fw-semibold py-2">
                                        <i class="bi bi-speedometer2 me-1"></i> Acessar Painel do RH
                                    </a>
                                    <a href="{{ route('empresa.vagas.create') }}" class="btn btn-outline-success btn-sm py-2">
                                        <i class="bi bi-plus-circle me-1"></i> Publicar Nova Vaga
                                    </a>
                                @else
                                    <a href="{{ route('empresa.cadastro') }}" class="btn btn-success fw-semibold py-2">
                                        <i class="bi bi-briefcase me-1"></i> Cadastrar Empresa
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('empresa.cadastro') }}" class="btn btn-success fw-semibold py-2">
                                    <i class="bi bi-briefcase me-1"></i> Cadastrar Empresa
                                </a>
                                <a href="{{ route('empresa.login') }}" class="btn btn-outline-secondary btn-sm py-2">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Acessar Painel do RH
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- 3. Prefeitura / Órgão Público -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-perfil h-100 p-4 text-center d-flex flex-column">
                        <div class="icon-circle bg-warning-subtle text-warning-emphasis mx-auto">
                            <i class="bi bi-bank2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Sou Prefeitura</h4>
                        <p class="text-secondary small flex-grow-1">
                            Disponibilize um portal municipal oficial com domínio próprio, impulsione a contratação local e monitore indicadores no <strong>Observatório Econômico</strong>.
                        </p>
                        <div class="d-grid gap-2 mt-4">
                            <a href="#" class="btn btn-warning fw-semibold py-2 text-dark">
                                <i class="bi bi-shield-check me-1"></i> Credenciar Município
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-sm py-2">
                                <i class="bi bi-graph-up me-1"></i> Acessar Observatório
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Seção: Municípios Parceiros Ativos -->
    <section class="py-5 bg-white border-top border-bottom" id="cidades">
        <div class="container text-center">
            <h3 class="fw-bold text-dark mb-2">Municípios Conectados à Plataforma</h3>
            <p class="text-muted mb-4">Escolha a cidade para acessar o portal local de vagas e oportunidades.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                @forelse($portais as $portal)
                    <a href="?portal={{ $portal->slug }}" class="badge-city shadow-sm">
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        <span>{{ $portal->cidade }}/{{ $portal->estado }}</span>
                        <small class="text-muted">&bull; {{ $portal->nome }}</small>
                    </a>
                @empty
                    <p class="text-muted">Nenhum município parceiro listado no momento.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center text-muted small">
            <p class="mb-1 text-light">&copy; {{ date('Y') }} IntalenTi Vagas &bull; Todos os direitos reservados.</p>
            <p class="mb-0 text-secondary">
                Arquitetura de Alta Concorrência &bull; Desenvolvido para suportar 1 milhão de acessos simultâneos.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selecionarCidade(slug) {
            if (slug) {
                window.location.href = '?portal=' + slug;
            }
        }
        function irParaCidade() {
            const select = document.getElementById('seletorCidade');
            if (select.value) {
                selecionarCidade(select.value);
            } else {
                alert('Por favor, selecione uma cidade na lista.');
            }
        }
    </script>
</body>
</html>
