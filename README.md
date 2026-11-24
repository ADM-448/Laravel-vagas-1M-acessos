# IntalenTi Vagas &bull; Plataforma SaaS de Empregabilidade Municipal (1M Acessos)

![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP 8.2+](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-Cache%20%26%20Queues-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![Livewire 4](https://img.shields.io/badge/Livewire-v4-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)
![Laravel Reverb](https://img.shields.io/badge/WebSockets-Laravel%20Reverb-4F46E5?style=for-the-badge&logo=socket.io&logoColor=white)
![Status](https://img.shields.io/badge/Status-Em%20Produção%20%2F%20Evolução-059669?style=for-the-badge)

---

## 📌 Visão Geral do Projeto

O **IntalenTi Vagas** é um ecossistema SaaS B2G/B2B/B2C desenvolvido para conectar **Prefeituras Municipais**, **Empresas Locais** e **Cidadãos em busca de Emprego**, com capacidade arquitetural projetada e otimizada para suportar até **1 milhão de acessos simultâneos**.

### 💼 Modelo de Negócio e Operação:
* **Prefeituras (SaaS B2G Pago):** Cada município contratante possui seu próprio portal customizado (domínio próprio ou subdomínio governamental, ex: `vagas.santos.sp.gov.br`), observatório econômico com dados em tempo real e moderação de empresas locais.
* **Empresas (Acesso Gratuito):** Cadastro validado oficialmente na Receita Federal (CNPJ ativo), publicação de vagas geolocalizadas, triagem eliminatória automatizada, gestão de candidatos em Pipeline/Kanban e convite de equipe (Sub-RHs) com papéis RBAC.
* **Candidatos (Acesso 100% Gratuito):** Cadastro de currículo único através do **IntalenTi ID**, permitindo que o profissional se candidate a vagas em qualquer portal municipal conveniado sem duplicar seus dados.

---

## 🏛️ Evolução Arquitetural (Histórico de Branches)

Este repositório registra a jornada evolutiva da solução:

| Versão | Branch | Tag | Descrição |
| :--- | :--- | :--- | :--- |
| **v1.0.0 (Legado)** | `legacy-php` | `v1.0.0-legacy` | Implementação original em PHP MVC nativo puro, PDO e sessões tradicionais. |
| **v2.0.0 (Moderno)** | `main` | `v2.0.0-laravel` | Refatoração completa para Laravel 12 com foco em concorrência massiva (1M acessos), Redis, Reverb, Actions e Eloquent otimizado. |

---

## ⚡ Engenharia de Alta Performance (Arquitetura para 1 Milhão de Acessos)

Para garantir estabilidade, latência inferior a 150ms e zero indisponibilidade em momentos de pico:

1. **Índices Compostos e Otimização SQL:**
   * Índices dedicados cobrindo os filtros mais frequentes de vagas (`portal_id, status, publicada_em`, `empresa_id, status`, `cidade, estado`).
   * Chave única combinada `(vaga_id, candidato_id)` para prevenir concorrência de candidaturas duplicadas a nível de motor de banco.

2. **Cache Hierárquico L1 / L2 com Redis:**
   * Cache de consultas pesadas (vagas em destaque, estatísticas e listagem municipal) com invalidação inteligente por tags.
   * Sessões dos usuários desacopladas e armazenadas em Redis para permitir auto-scaling horizontal de instâncias web.

3. **IntalenTi ID & Concorrência Atômica:**
   * Cadastro atômico via `CadastrarCandidatoAction` com sanitização prévia de CPF e Telefone antes de validações estritas (`unique:users,cpf`).
   * Suporte a tokens SSO descartáveis de uso único (One-Time Tokens) com expiração em 60 segundos.

4. **WebSockets em Tempo Real via Laravel Reverb:**
   * Mensageria bidirecional entre RH e candidatos sem polling contínuo no servidor, reduzindo drasticamente o consumo de banda e CPU.

5. **Filas Assíncronas (Queues):**
   * Processamento em background para disparo de e-mails transacionais (boas-vindas, recuperação de senha, convites de Sub-RH) e webhooks municipais.

---

## 📦 Módulos Implementados

### 🌐 Módulo 0: Hub Central & Landing Page
* Seletor dinâmico de municípios conveniados ativos no banco.
* Direcionamento inteligente por perfil de acesso (Candidato, Empresa, Prefeitura).
* Responsividade total com Bootstrap 5.

### 👤 Módulo 1: Portal do Candidato & Currículo Digital
* **Cadastro com Validação Rigorosa:** Validador oficial de CPF com algoritmo de dígitos verificadores reais (`App\Rules\Cpf`) e validador de Celular/WhatsApp brasileiro (`App\Rules\CelularWhatsapp`).
* **Seletor de Cidades:** Lista inteligente que vincula o munícipe à sua prefeitura ou permite entrada manual.
* **Painel do Currículo Único:** Gestão de Dados Pessoais, Experiências Profissionais, Formação Acadêmica e Cursos/Certificações.
* **Minhas Candidaturas:** Acompanhamento do status de cada vaga em que o candidato se inscreveu.

### 🏢 Módulo 2: Portal da Empresa & Gestão de RH
* **Validação de CNPJ & Integração Receita Federal:** Busca automática em tempo real dos dados cadastrais (Razão Social, Nome Fantasia, CNAE, Situação Cadastral ATIVA e Endereço) via API pública (BrasilAPI).
* **Multi-Prefeituras:** A empresa escolhe em quais municípios parceiros deseja atuar e divulgar oportunidades (`empresa_portal`).
* **Publicação de Vagas:** Formulário completo com tipo de contrato (CLT/PJ/Estágio), modalidade (Presencial/Híbrido/Remoto), faixa salarial ou a combinar, e regras afirmativas PCD.
* **Perguntas Eliminatórias de Triagem:** Criação de perguntas obrigatórias com eliminação automática de candidatos que não atendem aos pré-requisitos.
* **Pipeline / Funil de Candidatos:** Visualização Kanban dos candidatos por etapas (*Inscrito → Triagem → Entrevista → Aprovado → Contratado / Reprovado*) com movimentação ágil.
* **Gestão de Equipe (Sub-RHs - RBAC):** Convite de colaboradores com papéis definidos (`admin`, `gestor_vagas`, `recrutador`, `entrevistador`).

### 🏛️ Módulo 3: Portal do Município / Observatório Econômico *(Próxima Fase)*
* Subdomínio próprio da prefeitura e painel analítico com indicadores econômicos de emprego.

### 💬 Módulo 4: Chat em Tempo Real & Notificações *(Próxima Fase)*
* Chat instantâneo integrado entre recrutador e candidato via WebSockets (Reverb).

---

## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos:
* PHP 8.2 ou superior (com extensões `pdo`, `mbstring`, `openssl`, `curl`)
* Composer
* Node.js & NPM
* Redis (opcional para ambiente local; padrão array/sync habilitado)

### 1. Clonar o Repositório
```bash
git clone https://github.com/ADM-448/Laravel-vagas-1M-acessos.git
cd Laravel-vagas-1M-acessos
```

### 2. Instalar Dependências PHP
```bash
composer install
```

### 3. Configurar Variáveis de Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Executar Migrações e Seeders
```bash
# Executa as 16 migrações de alta performance e popula cidades/portais parceiros
php artisan migrate --seed
```

### 5. Iniciar o Servidor de Desenvolvimento
```bash
php artisan serve
```

Acesse no navegador: **[http://localhost:8000](http://localhost:8000)**

---

## 🗄️ Histórico de Dados Legados
Para fins de auditoria e referência histórica da migração, os dumps SQL da versão 1.0 estão preservados em:
* `database/legacy/BancoAtual.sql`
* `database/legacy/intale75_intalenti_mvcFEITO.sql`

---

## 📄 Licença
Desenvolvido por **ADM-448** &bull; Todos os direitos reservados.
