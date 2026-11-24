<?php

namespace Database\Seeders;

use App\Models\Candidato;
use App\Models\CursoHabilidade;
use App\Models\Empresa;
use App\Models\EmpresaUser;
use App\Models\ExperienciaProfissional;
use App\Models\FormacaoAcademica;
use App\Models\PerguntaVaga;
use App\Models\Portal;
use App\Models\User;
use App\Models\Vaga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criação dos Portais das Prefeituras (Tenants)
        $portalSantos = Portal::create([
            'nome' => 'Portal de Vagas de Santos',
            'slug' => 'santos',
            'dominio_principal' => 'vagas.santos.sp.gov.br',
            'subdominio' => 'santos',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'ibge_code' => '3548500',
            'cor_primaria' => '#0d6efd',
            'cor_secundaria' => '#198754',
            'status_licenca' => 'ativa',
            'licenca_expira_em' => now()->addYear(),
            'exige_aprovacao_empresa' => false,
        ]);

        $portalCampinas = Portal::create([
            'nome' => 'Emprega Campinas Oficial',
            'slug' => 'campinas',
            'dominio_principal' => 'empregos.campinas.sp.gov.br',
            'subdominio' => 'campinas',
            'cidade' => 'Campinas',
            'estado' => 'SP',
            'ibge_code' => '3509502',
            'cor_primaria' => '#003366',
            'cor_secundaria' => '#ff9900',
            'status_licenca' => 'ativa',
            'licenca_expira_em' => now()->addYear(),
            'exige_aprovacao_empresa' => true,
        ]);

        // 2. Criação de Usuários de Gestão das Prefeituras
        $adminSantos = User::create([
            'name' => 'Gestor Prefeitura Santos',
            'email' => 'admin@santos.sp.gov.br',
            'tipo_usuario' => 'prefeitura_admin',
            'password' => Hash::make('senha123'),
            'email_verified_at' => now(),
        ]);

        EmpresaUser::create([
            'user_id' => $adminSantos->id,
            'portal_id' => $portalSantos->id,
            'role' => 'admin',
            'status' => 'ativo',
        ]);

        // 3. Criação de Empresas com CNPJ válido
        $empresaTech = Empresa::create([
            'cnpj' => '33000167000101', // Petrobras ou similar institucional
            'razao_social' => 'IntalenTi Soluções em Tecnologia Ltda',
            'nome_fantasia' => 'IntalenTi Tech',
            'situacao_cadastral' => 'ATIVA',
            'ramo_atividade' => 'Desenvolvimento de Softwares e TI',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'cep' => '11010010',
            'status' => 'ativo',
        ]);

        // Vínculo da Empresa nos portais (atuando em Santos e Campinas)
        $empresaTech->portais()->attach($portalSantos->id, ['status_moderacao' => 'aprovado']);
        $empresaTech->portais()->attach($portalCampinas->id, ['status_moderacao' => 'aprovado']);

        // 4. Usuários de RH da Empresa e Sub-RHs
        $rhMaster = User::create([
            'name' => 'Marina Silva (RH Master)',
            'email' => 'rh@intalenti.com.br',
            'tipo_usuario' => 'empresa_rh',
            'password' => Hash::make('senha123'),
            'email_verified_at' => now(),
        ]);

        $subRhRecrutador = User::create([
            'name' => 'Carlos Souza (Recrutador TI)',
            'email' => 'carlos.recrutador@intalenti.com.br',
            'tipo_usuario' => 'empresa_rh',
            'password' => Hash::make('senha123'),
            'email_verified_at' => now(),
        ]);

        EmpresaUser::create([
            'user_id' => $rhMaster->id,
            'empresa_id' => $empresaTech->id,
            'role' => 'admin',
            'status' => 'ativo',
        ]);

        EmpresaUser::create([
            'user_id' => $subRhRecrutador->id,
            'empresa_id' => $empresaTech->id,
            'role' => 'recrutador',
            'status' => 'ativo',
        ]);

        // 5. Criação de Vagas
        $vagaDev = Vaga::create([
            'portal_id' => $portalSantos->id,
            'empresa_id' => $empresaTech->id,
            'recrutador_id' => $subRhRecrutador->id,
            'titulo' => 'Desenvolvedor Full Stack PHP / Laravel',
            'slug' => 'desenvolvedor-full-stack-php-laravel-' . Str::random(5),
            'descricao' => 'Venha fazer parte da equipe de engenharia do IntalenTi. Atuação em sistemas de alta escala.',
            'requisitos' => 'Experiência sólida com PHP moderno, Laravel 11/12, Livewire, MySQL e Redis.',
            'beneficios' => 'Vale Refeição, Plano de Saúde Nacional, Participação nos Lucros.',
            'experiencia' => 'com',
            'escolaridade_minima' => 'Superior Completo',
            'faixa_salarial_min' => 6000.00,
            'faixa_salarial_max' => 9500.00,
            'tipo_contrato' => 'CLT',
            'modalidade' => 'hibrido',
            'pcd' => 'sim',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'status' => 'publicada',
            'destaque' => true,
            'publicada_em' => now(),
        ]);

        // Perguntas de Triagem para a Vaga
        PerguntaVaga::create([
            'vaga_id' => $vagaDev->id,
            'pergunta' => 'Você tem mais de 2 anos de experiência prática com Laravel?',
            'tipo_resposta' => 'sim_nao',
            'obrigatoria' => true,
            'resposta_eliminatoria' => 'nao',
            'ordem' => 1,
        ]);

        PerguntaVaga::create([
            'vaga_id' => $vagaDev->id,
            'pergunta' => 'Tem disponibilidade para trabalhar no modelo Híbrido em Santos?',
            'tipo_resposta' => 'sim_nao',
            'obrigatoria' => true,
            'resposta_eliminatoria' => 'nao',
            'ordem' => 2,
        ]);

        // 6. Candidato com Conta Única Global (IntalenTi ID)
        $userCandidato = User::create([
            'name' => 'Lucas Mendonça',
            'email' => 'lucas.candidato@gmail.com',
            'cpf' => '12345678901',
            'telefone' => '13999998888',
            'tipo_usuario' => 'candidato',
            'password' => Hash::make('senha123'),
            'email_verified_at' => now(),
        ]);

        $candidato = Candidato::create([
            'user_id' => $userCandidato->id,
            'data_nascimento' => '1995-06-15',
            'genero' => 'masculino',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'resumo_profissional' => 'Desenvolvedor backend experiente em PHP, Laravel, APIs RESTful e bancos de dados.',
            'pretensao_salarial' => 7500.00,
            'disponibilidade' => 'imediata',
            'visivel_banco_talentos' => true,
        ]);

        ExperienciaProfissional::create([
            'candidato_id' => $candidato->id,
            'cargo' => 'Desenvolvedor PHP Pleno',
            'empresa' => 'Tech Soluções Web',
            'data_inicio' => '2021-02-01',
            'data_fim' => '2024-05-30',
            'atual' => false,
            'descricao_atividades' => 'Desenvolvimento de sistemas MVC, migração de bancos legados e integração com APIs.',
        ]);

        FormacaoAcademica::create([
            'candidato_id' => $candidato->id,
            'instituicao' => 'Universidade Santa Cecília (UNISANTA)',
            'curso' => 'Sistemas de Informação',
            'grau' => 'superior_completo',
            'data_inicio' => '2015-02-01',
            'data_fim' => '2019-12-15',
            'status' => 'completo',
        ]);

        CursoHabilidade::create([
            'candidato_id' => $candidato->id,
            'titulo' => 'Laravel Avançado & Arquitetura de Software',
            'instituicao' => 'Alura',
            'carga_horaria' => 60,
            'ano_conclusao' => 2023,
        ]);
    }
}
