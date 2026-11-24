# IntalenTi Vagas - Versão 1.0.0 (Legado PHP MVC)

> **Nota de Histórico e Arquitetura:** Este commit e a branch `legacy-php` preservam a implementação original da plataforma IntalenTi Vagas, desenvolvida em PHP nativo utilizando arquitetura Model-View-Controller (MVC) pura e MySQL.

---

## 🏛️ Sobre o Projeto Legado
A plataforma **IntalenTi Vagas v1.0** foi concebida para conectar candidatos a empregos, empresas contratantes e prefeituras municipais em um ambiente unificado.

### Principais Funcionalidades da Versão 1.0:
- **Painel Administrativo:** Gestão de usuários, empresas e moderação de vagas.
- **Portal do Candidato:** Cadastro de perfil, elaboração de currículo e acompanhamento de candidaturas.
- **Portal da Empresa:** Abertura e edição de vagas de emprego, visualização de inscritos.
- **Módulo de Prefeitura:** Painel gerencial e estatísticas municipais de contratação.
- **Chat Básico:** Mensagens diretas entre recrutadores e candidatos.
- **Geolocalização:** Busca de vagas próximas por cálculo de distância geográfica (`GeoUtils.php`).

---

## 🛠️ Stack Tecnológica (v1.0.0):
- **Linguagem:** PHP 8.x (Estruturado em MVC nativo sem framework)
- **Banco de Dados:** MySQL / MariaDB (Driver PDO)
- **Autenticação:** PHP Native Sessions com Hash Bcrypt
- **Roteamento:** Dispatcher próprio via `Core.php` e `.htaccess`
- **Frontend:** HTML5, CSS3, JavaScript Vanilla e Bootstrap

---

## 📁 Estrutura de Diretórios:
```text
├── migrations/             # Scripts SQL de evolução do banco
├── public/                 # Ponto de entrada (index.php), assets CSS, JS e imagens
├── scripts/                # Scripts utilitários de indexação e performance
├── src/
│   ├── Config/             # Configurações de conexão e constantes do banco
│   ├── Controllers/        # Controladores das entidades (Vagas, Candidato, Empresa, etc.)
│   ├── Core/               # Motor de roteamento, controle base e cache nativo
│   ├── Models/             # Modelos de dados e queries PDO
│   ├── Utils/              # Utilitários (GeoUtils, Mailer, Validator)
│   └── Views/              # Templates PHP por módulo (Auth, Candidato, Vagas, etc.)
├── BancoAtual.sql          # Dump da estrutura inicial do banco de dados
├── composer.json           # Dependências complementares (PHPMailer, etc.)
└── index.php               # Front controller principal
```

---

## 🔄 Evolução e Migração para Laravel 12 (v2.0.0)
Com o crescimento acelerado da demanda municipal e a necessidade de suportar picos de **1 milhão de acessos simultâneos** de forma resiliente, a plataforma passou por uma refatoração arquitetural completa para **Laravel 12**, implementando:
1. **IntalenTi ID:** SSO centralizado e cadastro unificado do cidadão por CPF.
2. **Alta Concorrência:** Cache L1/L2 distribuído em Redis, filas assíncronas e índices compostos de banco de dados.
3. **WebSockets em Tempo Real:** Comunicação instantânea via Laravel Reverb.
4. **SaaS Multi-Tenant Municipal B2G:** Portais independentes por domínio/subdomínio de prefeitura parceira.

*Consulte a branch `main` e a tag `v2.0.0-laravel` para a arquitetura moderna completa.*
