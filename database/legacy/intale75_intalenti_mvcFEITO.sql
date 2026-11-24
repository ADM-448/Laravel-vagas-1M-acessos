-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 16/01/2026 às 10:49
-- Versão do servidor: 8.0.44-35
-- Versão do PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `intale75_intalenti_mvc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `assinaturas`
--

CREATE TABLE `assinaturas` (
  `id` int UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `plano_id` int UNSIGNED NOT NULL,
  `id_cobranca_externa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo_checkout` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_pagamento` text COLLATE utf8mb4_general_ci,
  `status` enum('pendente','ativa','inativa','cancelada') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidatos`
--

CREATE TABLE `candidatos` (
  `id` bigint UNSIGNED NOT NULL,
  `portal_id` int DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nome_completo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `resumo_profissional` text COLLATE utf8mb4_unicode_ci,
  `sobre_mim` text COLLATE utf8mb4_unicode_ci,
  `curriculo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `situacao_profissional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_pretendido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faixa_salarial` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_civil` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `escolaridade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nacionalidade` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Brasileiro(a)',
  `rne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idiomas` text COLLATE utf8mb4_unicode_ci,
  `carteira_habilitacao` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `candidatos`
--

INSERT INTO `candidatos` (`id`, `portal_id`, `user_id`, `nome_completo`, `cpf`, `data_nascimento`, `email`, `telefone`, `whatsapp`, `cep`, `cidade`, `estado`, `latitude`, `longitude`, `resumo_profissional`, `sobre_mim`, `curriculo_path`, `created_at`, `updated_at`, `situacao_profissional`, `cargo_pretendido`, `faixa_salarial`, `estado_civil`, `escolaridade`, `sexo`, `nacionalidade`, `rne`, `idiomas`, `carteira_habilitacao`) VALUES
(27, NULL, 148, 'Ademar de Araújo Teisen', '13130525904', '2004-01-29', 'ademarintalenti@gmail.com', '4430283953', '44 99544673', '87047-130', 'Maringá', 'PR', -23.4152328, -51.8865949, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', '148_1768507211.pdf', NULL, NULL, '', '', '', 'Solteiro(a)', 'Ensino Superior', 'Masculino', 'Brasileiro(a)', '', 'Espanhol (Básico), Português (Fluente)', 'A, B'),
(28, NULL, 149, 'ADEMAR JEFFERSON FERREIRA TEISEN', '02232964906', '1977-04-26', 'ademar2604@gmail.com', '44991488983', '44991488983', '87047-130', 'Maringá', 'PR', -23.4152328, -51.8865949, 'sabe tudooo', 'sou o candidato', NULL, NULL, NULL, '', '', '', 'Casado(a)', 'Doutorado', 'Masculino', 'Brasileiro(a)', '', 'Inglês (Básico), Espanhol (Básico), Português (Básico)', 'D'),
(29, NULL, 150, 'Roberto', '65114081675', '2005-06-02', 'robertosanz2005@gmail.com', '', '11984066971', '87060-665', 'Maringá', 'PR', -23.4514190, -51.9481981, 'Abc', 'Abc', NULL, NULL, NULL, '', '', '', 'Solteiro(a)', 'Ensino Superior', 'Masculino', 'Brasileiro(a)', '', 'Inglês (Intermediário), Português (Fluente)', 'B');

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidaturas`
--

CREATE TABLE `candidaturas` (
  `id` int UNSIGNED NOT NULL,
  `vaga_id` bigint UNSIGNED NOT NULL,
  `candidato_id` bigint UNSIGNED NOT NULL,
  `data_candidatura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Enviada','Visualizada','Em Processo','Aprovado','Rejeitado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Enviada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidaturas`
--

INSERT INTO `candidaturas` (`id`, `vaga_id`, `candidato_id`, `data_candidatura`, `status`) VALUES
(143, 120, 28, '2026-01-15 20:07:23', 'Em Processo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chats`
--

CREATE TABLE `chats` (
  `id` int UNSIGNED NOT NULL,
  `candidatura_id` int UNSIGNED NOT NULL,
  `status` enum('aberto','fechado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aberto',
  `iniciado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chats`
--

INSERT INTO `chats` (`id`, `candidatura_id`, `status`, `iniciado_em`) VALUES
(49, 143, 'aberto', '2026-01-15 20:07:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `convites_empresa`
--

CREATE TABLE `convites_empresa` (
  `id` int UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_por_user_id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unico',
  `usado` tinyint(1) NOT NULL DEFAULT '0',
  `data_expiracao` datetime DEFAULT ((now() + interval 24 hour))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `convites_empresa`
--

INSERT INTO `convites_empresa` (`id`, `empresa_id`, `codigo`, `criado_por_user_id`, `tipo`, `usado`, `data_expiracao`) VALUES
(22, 32, 'CONV-REU-32-692461eb19952', 85, 'reutilizavel', 0, NULL),
(27, 32, 'CONV-6968fbe4517ba-1342', 85, 'unico', 0, '2026-01-16 15:38:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos_complementares`
--

CREATE TABLE `cursos_complementares` (
  `id` bigint UNSIGNED NOT NULL,
  `candidato_id` bigint UNSIGNED NOT NULL,
  `nome_curso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `instituicao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `localidade` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ano_conclusao` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos_complementares`
--

INSERT INTO `cursos_complementares` (`id`, `candidato_id`, `nome_curso`, `instituicao`, `localidade`, `ano_conclusao`) VALUES
(163, 15, 'Ademar de Araújo Teisen', 'Senai3', 'Maringá', 3000),
(164, 15, 'Ademar de Araújo Teisen', 'Senai', 'Maringá', 2000),
(166, 27, 'Pegador profissional ', 'Rei delas', 'Maringá', 2022);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint UNSIGNED NOT NULL,
  `portal_id` int DEFAULT NULL,
  `nome_empresa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_fantasia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('empresa','prefeitura') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'empresa',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `cnpj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logradouro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complemento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dominio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `portal_id`, `nome_empresa`, `nome_fantasia`, `tipo`, `status`, `cnpj`, `website`, `logo_path`, `ativo`, `created_at`, `updated_at`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `dominio`) VALUES
(59, NULL, 'IntalenTIAdmin', NULL, 'prefeitura', 1, '00.000.000/0000-00', NULL, NULL, 1, '2026-01-15 19:17:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intalenti.com.br'),
(60, 59, 'Intalenti Headhunter e Consultoria LTDA', 'IntalenTI', 'empresa', 1, '32806103000130', NULL, '32806103000130.png', 1, NULL, NULL, '87013040', 'Avenida São Paulo', '1713', 'Apto', 'Zona 01', 'Maringá', 'PR', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa_user`
--

CREATE TABLE `empresa_user` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role` enum('admin','membro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'membro',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empresa_user`
--

INSERT INTO `empresa_user` (`id`, `empresa_id`, `user_id`, `role`, `created_at`, `updated_at`) VALUES
(89, 60, 147, 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `experiencias_profissionais`
--

CREATE TABLE `experiencias_profissionais` (
  `id` int UNSIGNED NOT NULL,
  `candidato_id` bigint UNSIGNED NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `emprego_atual` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `experiencias_profissionais`
--

INSERT INTO `experiencias_profissionais` (`id`, `candidato_id`, `cargo`, `empresa`, `descricao`, `data_inicio`, `data_fim`, `emprego_atual`) VALUES
(226, 15, 'Gerente de Negócios', 'Beto2 Rh', 'meme do ano', '2026-01-07', NULL, 1),
(231, 27, 'SDR', 'Intalenti Headhunter e Consultoria LTDA', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', '2025-12-31', '2026-01-15', 0),
(232, 27, 'vendedor2', 'monitur', 'Mimimimimimimimimi', '2026-01-01', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `formacoes_academicas`
--

CREATE TABLE `formacoes_academicas` (
  `id` int UNSIGNED NOT NULL,
  `candidato_id` bigint UNSIGNED NOT NULL,
  `grau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `curso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `instituicao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `localidade` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formacoes_academicas`
--

INSERT INTO `formacoes_academicas` (`id`, `candidato_id`, `grau`, `curso`, `instituicao`, `localidade`, `data_inicio`, `data_fim`, `status`) VALUES
(228, 15, 'Ensino Médio', 'CCI', 'ccim', 'Maringá', '2026-01-07', '2026-01-08', 'Cursando'),
(230, 27, 'Ensino Superior', 'Ads', 'ccim', 'Maringá', '2026-01-01', '2026-01-16', 'Trancado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_chat`
--

CREATE TABLE `mensagens_chat` (
  `id` int UNSIGNED NOT NULL,
  `chat_id` int UNSIGNED NOT NULL,
  `remetente_id` bigint UNSIGNED NOT NULL COMMENT 'ID da tabela USERS',
  `mensagem` text COLLATE utf8mb4_general_ci NOT NULL,
  `enviada_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lida` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagens_chat`
--

INSERT INTO `mensagens_chat` (`id`, `chat_id`, `remetente_id`, `mensagem`, `enviada_em`, `lida`) VALUES
(138, 49, 147, 'Tes', '2026-01-15 20:07:37', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_08_195052_create_resumo_candidatos_table', 1),
(5, '2025_09_08_195100_create_empresas_table', 1),
(6, '2025_09_08_195101_create_vagas_table', 1),
(7, '2025_09_08_195111_create_candidato_vaga_table', 1),
(8, '2025_09_08_195112_create_prefeitura.table', 1),
(9, '2025_09_11_154222_create_empresa_user_table', 1),
(10, '2025_09_15_183727_add_prefeitura_id_to_empresas_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'ID de quem recebe a notificação',
  `mensagem` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT '0',
  `criada_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `user_id`, `mensagem`, `link`, `lida`, `criada_em`) VALUES
(2, 15, 'Status da sua candidatura para \'professor\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-10-13 11:56:07'),
(3, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-10-13 16:47:30'),
(4, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=2', 1, '2025-10-13 16:49:37'),
(5, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=1', 1, '2025-10-13 16:50:13'),
(6, 15, 'Entrevista agendada para a vaga \'SDR\'. Veja os detalhes no chat.', 'chat.php?id=1', 1, '2025-10-13 16:55:52'),
(7, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-10-13 16:57:44'),
(8, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Rejeitado', 'minhas_candidaturas.php', 1, '2025-10-13 16:57:48'),
(10, 15, 'Status da sua candidatura para \'Vendedor De  w\' atualizado para: Em Processo', 'minhas_candidaturas.php', 1, '2025-10-14 22:00:57'),
(12, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=3', 1, '2025-10-14 22:01:23'),
(13, 15, 'Entrevista agendada para a vaga \'Vendedor De  w\'. Veja os detalhes no chat.', 'chat.php?id=3', 1, '2025-10-14 22:01:51'),
(15, 15, 'Status da sua candidatura para \'SDR33\' atualizado para: Enviada', 'minhas_candidaturas.php', 1, '2025-10-15 13:10:33'),
(16, 15, 'Status da sua candidatura para \'SDR33\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-10-15 13:10:45'),
(17, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=4', 1, '2025-10-15 13:11:36'),
(18, 15, 'Entrevista agendada para a vaga \'SDR33\'. Veja os detalhes no chat.', 'chat.php?id=4', 1, '2025-10-15 13:12:13'),
(20, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=1', 1, '2025-10-15 18:16:49'),
(23, 15, 'Entrevista agendada para a vaga \'SDR\'. Veja os detalhes no chat.', 'chat.php?id=1', 1, '2025-10-15 19:58:10'),
(24, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-10-15 19:58:15'),
(31, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=5', 1, '2025-10-21 18:12:16'),
(35, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Em Processo', 'minhas_candidaturas.php', 1, '2025-10-22 01:52:30'),
(36, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=5', 1, '2025-10-22 01:52:39'),
(40, 15, 'Status da sua candidatura para \'Operador de maquina\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-10-22 13:00:22'),
(41, 15, 'Entrevista agendada para a vaga \'Operador de maquina\'. Veja os detalhes no chat.', 'chat.php?id=6', 1, '2025-10-22 13:00:45'),
(42, 15, 'Entrevista agendada para a vaga \'Operador de maquina\'. Veja os detalhes no chat.', 'chat.php?id=6', 1, '2025-10-22 13:09:32'),
(43, 15, 'Status da sua candidatura para \'Operador de maquina\' atualizado para: Rejeitado', 'minhas_candidaturas.php', 1, '2025-10-22 13:09:42'),
(44, 15, 'Entrevista agendada para a vaga \'Operador de maquina\'. Veja os detalhes no chat.', 'chat.php?id=6', 1, '2025-10-22 13:10:03'),
(45, 15, 'Entrevista agendada para a vaga \'Operador de maquina\'. Veja os detalhes no chat.', 'chat.php?id=6', 1, '2025-10-22 13:10:08'),
(46, 15, 'Entrevista agendada para a vaga \'Operador de maquina\'. Veja os detalhes no chat.', 'chat.php?id=6', 1, '2025-10-22 13:10:32'),
(51, 15, 'Status da sua candidatura para \'Operador de maquina\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-10-24 13:39:59'),
(52, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=6', 1, '2025-10-24 13:47:44'),
(57, 15, 'Status da sua candidatura para \'Vendedor De Roupa3\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-10-30 17:43:20'),
(58, 15, 'Você tem uma nova mensagem de beto.', 'chat.php?id=8', 1, '2025-10-30 17:43:32'),
(63, 15, 'Status da sua candidatura para \'SDR\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-10-31 11:42:03'),
(72, 15, 'Status da sua candidatura para \'Dev plus\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-11-03 12:06:49'),
(73, 15, 'Você tem uma nova mensagem de Beto2 Rh.', 'chat.php?id=11', 1, '2025-11-03 12:07:19'),
(85, 15, 'Você tem uma nova mensagem de convidado2.', 'chat.php?id=13', 1, '2025-11-05 13:00:59'),
(87, 15, 'Você tem uma nova mensagem de Beto2 Rh.', 'chat.php?id=14', 1, '2025-11-05 13:03:54'),
(88, 15, 'Status da sua candidatura para \'professor\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-11-05 13:04:44'),
(89, 15, 'Entrevista agendada para a vaga \'professor\'. Veja os detalhes no chat.', 'chat.php?id=13', 1, '2025-11-05 13:07:40'),
(95, 15, 'Status da sua candidatura para \'Raciocinio Logico\' atualizado para: Em Processo', 'minhas_candidaturas.php', 1, '2025-11-06 11:39:51'),
(98, 15, 'Status da sua candidatura para \'Dev plus\' atualizado para: Em Processo', 'minhas_candidaturas.php', 1, '2025-11-06 11:53:31'),
(99, 15, 'Você tem uma nova mensagem de MaringaPref.', 'chat.php?id=15', 1, '2025-11-06 11:53:39'),
(117, 15, 'Status da sua candidatura para \'Tratorista (Vaga test)\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-11-11 19:35:08'),
(118, 15, 'Você tem uma nova mensagem de Rh IntalenTI.', 'chat.php?id=19', 1, '2025-11-11 19:35:21'),
(121, 85, 'Novo candidato para a vaga \'Tratorista (Vaga test)\'!', 'ver_candidatos.php?vaga_id=41', 1, '2025-11-17 13:56:45'),
(122, 85, 'Novo candidato para a vaga \'teste Localização4\'!', 'ver_candidatos.php?vaga_id=46', 1, '2025-11-17 19:20:53'),
(123, 85, 'Novo candidato para a vaga \'Local 5 - intalenti\'!', 'ver_candidatos.php?vaga_id=47', 1, '2025-11-17 20:00:00'),
(124, 85, 'Novo candidato para a vaga \'teste Localização4\'!', 'ver_candidatos.php?vaga_id=46', 1, '2025-11-18 15:17:13'),
(125, 15, 'Você tem uma nova mensagem de Alberto -  Beto.', 'chat.php?id=20', 1, '2025-11-18 15:17:47'),
(126, 85, 'Você tem uma nova mensagem de Joao Costa Vinte.', 'chat.php?id=20', 1, '2025-11-18 15:18:00'),
(127, 85, 'Novo candidato para a vaga \'teste Localização4\'!', 'ver_candidatos.php?vaga_id=46', 1, '2025-11-18 15:46:33'),
(128, 85, 'Novo candidato para a vaga \'Restaurante perto\'!', 'ver_candidatos.php?vaga_id=47', 1, '2025-11-18 15:47:06'),
(129, 85, 'Novo candidato para a vaga \'teste Localização4\'!', 'ver_candidatos.php?vaga_id=46', 1, '2025-11-19 11:36:09'),
(130, 85, 'Novo candidato para a vaga \'Estoquista Test\'!', 'ver_candidatos.php?vaga_id=42', 1, '2025-11-19 11:37:09'),
(131, 85, 'Novo candidato para a vaga \'Restaurante perto\'!', 'ver_candidatos.php?vaga_id=47', 1, '2025-11-19 11:37:37'),
(132, 85, 'Novo candidato para a vaga \'Adm Financeiro Mga\'!', 'ver_candidatos.php?vaga_id=50', 1, '2025-11-19 12:21:37'),
(133, 85, 'Novo candidato para a vaga \'Adm Financeiro\'!', 'ver_candidatos.php?vaga_id=49', 1, '2025-11-19 12:33:12'),
(134, 85, 'Novo candidato para a vaga \'Vaga Sarandi\'!', 'ver_candidatos.php?vaga_id=51', 1, '2025-11-19 12:33:33'),
(135, 85, 'Novo candidato para a vaga \'Adm Financeiro Mga\'!', 'ver_candidatos.php?vaga_id=50', 1, '2025-11-19 12:36:36'),
(136, 85, 'Novo candidato para a vaga \'Adm Financeiro\'!', 'ver_candidatos.php?vaga_id=49', 1, '2025-11-19 12:37:01'),
(138, 15, 'Você tem uma nova mensagem de Alberto -  Beto.', 'chat.php?id=21', 1, '2025-11-19 12:37:40'),
(139, 85, 'Você tem uma nova mensagem de Joao Costa Vinte.', 'chat.php?id=21', 1, '2025-11-19 12:37:56'),
(140, 15, 'Status da sua candidatura para \'Adm Financeiro\' atualizado para: Visualizada', 'minhas_candidaturas.php', 1, '2025-11-19 12:43:53'),
(141, 15, 'Status da sua candidatura para \'Adm Financeiro\' atualizado para: Em Processo', 'minhas_candidaturas.php', 1, '2025-11-19 12:44:03'),
(142, 15, 'Status da sua candidatura para \'Adm Financeiro\' atualizado para: Aprovado', 'minhas_candidaturas.php', 1, '2025-11-19 12:44:10'),
(144, 85, 'Novo candidato para a vaga \'Vaga Sarandi\'!', 'ver_candidatos.php?vaga_id=51', 1, '2025-11-19 12:50:33'),
(145, 15, 'Você tem uma nova mensagem de Alberto -  Beto.', 'chat.php?id=22', 1, '2025-11-19 13:22:08'),
(146, 15, 'Você tem uma nova mensagem de Alberto -  Beto.', 'chat.php?id=22', 1, '2025-11-19 13:29:17'),
(147, 85, 'Você tem uma nova mensagem de Joao Costa Vinte.', 'chat.php?id=22', 1, '2025-11-19 13:29:30'),
(148, 15, 'Você tem uma nova mensagem de Alberto -  Beto.', 'chat.php?id=22', 1, '2025-11-19 13:33:48'),
(149, 85, 'Novo candidato para a vaga \'SDR\'!', 'ver_candidatos.php?vaga_id=52', 1, '2025-11-19 17:05:51'),
(150, 15, 'Nova mensagem de Alberto -  Beto sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-21 12:36:19'),
(151, 85, 'Nova mensagem de Joao Costa Vinte sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-21 12:36:28'),
(175, 85, 'Novo candidato para: SDR', 'ver_candidatos.php?vaga_id=52', 1, '2025-11-21 14:57:49'),
(180, 85, 'Novo candidato para: Vaga Sarandi', 'ver_candidatos.php?vaga_id=51', 1, '2025-11-21 21:10:28'),
(181, 85, 'Nova mensagem de Joao Costa Vinte sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-21 21:10:36'),
(185, 15, 'Nova mensagem de ademarintalenti@gmail.com sobre a vaga Adm Financeiro', 'chat.php?id=26', 1, '2025-11-21 21:11:55'),
(186, 85, 'Nova mensagem de Joao Costa Vinte sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-21 21:12:02'),
(188, 15, 'Nova mensagem de ademarintalenti@gmail.com sobre a vaga Adm Financeiro', 'chat.php?id=26', 1, '2025-11-21 21:12:21'),
(189, 15, 'Status atualizado: SDR', 'minhas_candidaturas.php', 1, '2025-11-24 13:30:29'),
(190, 15, 'Status atualizado: SDR', 'minhas_candidaturas.php', 1, '2025-11-24 13:30:49'),
(191, 15, 'Nova mensagem de Alberto -  Beto sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 13:31:12'),
(192, 85, 'Novo candidato para a vaga \'Adm Financeiro Mga2\'!', 'ver_candidatos.php?vaga_id=50', 1, '2025-11-24 13:38:11'),
(201, 85, 'Novo candidato: SDR', 'ver_candidatos.php?vaga_id=52', 1, '2025-11-24 14:14:56'),
(217, 15, 'Status atualizado: Adm Financeiro', 'minhas_candidaturas.php', 1, '2025-11-24 16:01:27'),
(218, 15, 'Status atualizado: SDR', 'minhas_candidaturas.php', 1, '2025-11-24 16:03:04'),
(219, 85, 'Nova mensagem de Joao Costa Vinte sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:20:31'),
(220, 15, 'Nova mensagem de Alberto -  Betão sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:24:16'),
(221, 15, 'Nova mensagem de mimimi sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:29:17'),
(222, 85, 'Nova mensagem de Joao Costa Vinte sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:29:43'),
(223, 15, 'Nova mensagem de Alberto -  Betão sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:29:55'),
(224, 15, 'Nova mensagem de Alberto -  Betão sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:50:37'),
(225, 15, 'Nova mensagem de mimimi sobre a vaga SDR', 'chat.php?id=23', 1, '2025-11-24 16:50:47'),
(226, 85, 'Novo candidato: SDR', 'ver_candidatos.php?vaga_id=52', 1, '2025-11-24 16:53:59'),
(228, 85, 'Novo candidato para a vaga: <strong>Vaga 2200</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/64', 1, '2026-01-09 00:39:59'),
(229, 85, 'Novo candidato para a vaga: <strong>Vaga 2200</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/64', 1, '2026-01-09 00:40:12'),
(230, 15, 'O status da sua candidatura para <strong>Vaga 2200</strong> mudou para: <strong>Em Processo</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/show/64', 1, '2026-01-09 00:40:27'),
(237, 85, 'Nova mensagem de <strong>Ademar Araújo Teisen Candidato</strong> sobre a vaga <strong>SDR</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/chat/index/30', 1, '2026-01-09 00:47:32'),
(238, 85, 'Novo candidato para a vaga: <strong>Vaga 2200</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/64', 1, '2026-01-09 00:52:07'),
(239, 85, 'Novo candidato para a vaga: <strong>Vaga 2200</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/64', 1, '2026-01-09 16:22:40'),
(243, 15, 'O status da sua candidatura para <strong>Adm Financeiro</strong> mudou para: <strong>Visualizada</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/show/57', 1, '2026-01-09 17:14:31'),
(244, 15, 'O status da sua candidatura para <strong>Adm Financeiro</strong> mudou para: <strong>Em Processo</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/show/57', 1, '2026-01-09 17:14:37'),
(245, 15, 'O status da sua candidatura para <strong>Adm Financeiro</strong> mudou para: <strong>Aprovado</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/show/57', 1, '2026-01-09 17:14:47'),
(246, 85, 'Novo candidato para a vaga: <strong>programador</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/66', 1, '2026-01-09 17:58:46'),
(249, 85, 'Novo candidato para a vaga: <strong>programador</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/66', 1, '2026-01-09 18:07:52'),
(271, 85, 'Nova mensagem de <strong>Ademar Araújo Teisen Candidato</strong> sobre a vaga <strong>RH 1</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/chat/index/35', 1, '2026-01-09 19:27:39'),
(272, 85, 'Novo candidato para a vaga: <strong>Analista de Marketing</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/85', 1, '2026-01-09 23:39:48'),
(273, 11, 'Novo candidato para a vaga: <strong>Vaga Recente Teste #4</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/105', 1, '2026-01-09 23:40:09'),
(274, 85, 'Novo candidato para a vaga: <strong>Desenvolvedor PHP Junior</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/94', 1, '2026-01-10 00:08:56'),
(275, 85, 'Novo candidato para a vaga: <strong>Auxiliar Administrativo</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/93', 1, '2026-01-12 15:32:55'),
(277, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/86', 1, '2026-01-12 16:55:10'),
(278, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/86', 1, '2026-01-12 16:55:48'),
(281, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/95', 1, '2026-01-13 14:58:26'),
(282, 15, 'O status da sua candidatura para <strong>Recepcionista</strong> mudou para: <strong>Em Processo</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/show/95', 1, '2026-01-13 14:59:07'),
(283, 15, 'Nova mensagem de <strong>Intalenti Headhunter e Consultoria Ltda</strong> sobre a vaga <strong>Recepcionista</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/chat/index/40', 1, '2026-01-13 14:59:28'),
(284, 85, 'Novo candidato para a vaga: <strong>Estagiário de Direito 2</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/91', 1, '2026-01-13 15:33:09'),
(285, 85, 'Novo candidato para a vaga: <strong>Estagiário de Direito 2</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/91', 1, '2026-01-13 15:36:47'),
(286, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 15:40:56'),
(287, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/95', 1, '2026-01-13 15:43:48'),
(288, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 15:50:55'),
(289, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 15:55:25'),
(290, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 15:59:56'),
(291, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 16:03:52'),
(292, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 16:08:57'),
(293, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 16:10:03'),
(294, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 16:20:12'),
(295, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/81', 1, '2026-01-13 16:24:13'),
(296, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost/Projetos%20PHP/IntalenTi%20Vagas%20Antigravity/IntalenTIVagasMVC/public/vagas/candidatos/95', 1, '2026-01-13 16:28:39'),
(297, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost:8000/vagas/candidatos/95', 1, '2026-01-13 16:47:27'),
(298, 15, 'Nova mensagem de <strong>Intalenti Headhunter e Consultoria Ltda</strong> sobre a vaga <strong>Recepcionista</strong>', 'http://localhost:8000/chat/index/46', 1, '2026-01-13 16:48:23'),
(299, 85, 'Nova mensagem de <strong>Joao Costa Vinte</strong> sobre a vaga <strong>Recepcionista</strong>', 'http://localhost:8000/chat/index/46', 1, '2026-01-13 16:48:35'),
(300, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost:8000/vagas/candidatos/86', 1, '2026-01-13 16:49:13'),
(301, 85, 'Nova mensagem de <strong>Joao Costa Vinte</strong> sobre a vaga <strong>Recepcionista</strong>', 'http://localhost:8000/chat/index/46', 1, '2026-01-13 17:03:24'),
(302, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost:8000/vagas/candidatos/95', 1, '2026-01-14 19:12:32'),
(303, 15, 'Nova mensagem de <strong>Intalenti Headhunter e Consultoria Ltda</strong> sobre a vaga <strong>Recepcionista</strong>', 'http://localhost:8000/chat/index/47', 1, '2026-01-14 23:47:46'),
(305, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost:8000/vagas/candidatos/95', 1, '2026-01-15 00:27:03'),
(306, 85, 'Novo candidato para a vaga: <strong>Recepcionista</strong>', 'http://localhost:8000/vagas/candidatos/95', 1, '2026-01-15 00:44:10'),
(308, 85, 'Novo candidato para a vaga: <strong>Designer Gráfico</strong>', 'http://localhost:8000/vagas/candidatos/86', 1, '2026-01-15 17:12:23'),
(310, 85, 'Novo candidato para a vaga: <strong>Vaga 3</strong>', 'http://localhost:8000/vagas/candidatos/114', 1, '2026-01-15 18:36:10'),
(311, 85, 'Novo candidato para a vaga: <strong>Vaga 3</strong>', 'http://localhost:8000/vagas/candidatos/114', 1, '2026-01-15 18:36:23'),
(312, 85, 'Novo candidato para a vaga: <strong>Vaga 2</strong>', 'http://localhost:8000/vagas/candidatos/113', 1, '2026-01-15 18:36:51'),
(313, 15, 'O status da sua candidatura para <strong>Vendedor De Roupa</strong> mudou para: <strong>Em Processo</strong>', 'http://localhost:8000/vagas/show/115', 0, '2026-01-15 18:37:15'),
(314, 15, 'Nova mensagem de <strong>Intalenti Headhunter e Consultoria Ltda</strong> sobre a vaga <strong>Vendedor De Roupa</strong>', 'http://localhost:8000/chat/index/48', 0, '2026-01-15 18:37:25'),
(315, 145, 'Bem-vindo! Para se candidatar, você precisa completar seu currículo.', 'http://localhost:8000/curriculo', 1, '2026-01-15 18:42:24'),
(317, 85, 'Novo candidato para a vaga: <strong>professor</strong>', 'http://localhost:8000/vagas/candidatos/116', 0, '2026-01-15 20:10:58'),
(318, 148, 'Bem-vindo! Para se candidatar, você precisa completar seu currículo.', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/curriculo', 1, '2026-01-15 19:52:33'),
(319, 149, 'Bem-vindo! Para se candidatar, você precisa completar seu currículo.', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/curriculo', 0, '2026-01-15 20:04:49'),
(320, 147, 'Novo candidato para a vaga: <strong>Vaga 1</strong>', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/vagas/candidatos/120', 1, '2026-01-15 20:06:53'),
(321, 147, 'Novo candidato para a vaga: <strong>Vaga 1</strong>', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/vagas/candidatos/120', 1, '2026-01-15 20:07:23'),
(322, 149, 'Nova mensagem de <strong>Intalenti Headhunter e Consultoria LTDA</strong> sobre a vaga <strong>Vaga 1</strong>', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/chat/index/49', 0, '2026-01-15 20:07:37'),
(323, 149, 'O status da sua candidatura para <strong>Vaga 1</strong> mudou para: <strong>Em Processo</strong>', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/vagas/show/120', 0, '2026-01-15 20:10:02'),
(324, 150, 'Bem-vindo! Para se candidatar, você precisa completar seu currículo.', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/curriculo', 1, '2026-01-15 21:34:28'),
(325, 147, 'Novo candidato para a vaga: <strong>Vaga 1</strong>', 'https://intalenti.com.br/vagas/IntalenTIVagasMVC/public/vagas/candidatos/120', 1, '2026-01-16 11:56:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas_vaga`
--

CREATE TABLE `perguntas_vaga` (
  `id` int UNSIGNED NOT NULL,
  `vaga_id` bigint UNSIGNED NOT NULL,
  `texto_pergunta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `eliminatoria` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perguntas_vaga`
--

INSERT INTO `perguntas_vaga` (`id`, `vaga_id`, `texto_pergunta`, `eliminatoria`) VALUES
(133, 114, 'essa é', 1),
(134, 114, 'essa nao', 0),
(135, 115, 'Eliminatória', 1),
(136, 116, 'sim', 1),
(137, 116, 'nao é', 0),
(138, 118, 'Tem Carteira?', 1),
(139, 118, 'Recebe auxilio?', 1),
(142, 120, 'elimina', 1),
(143, 120, 'não elimina', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_externo_faturagil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `limite_vagas` int DEFAULT NULL COMMENT 'NULL para ilimitado',
  `descricao` text COLLATE utf8mb4_general_ci,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `planos`
--

INSERT INTO `planos` (`id`, `nome`, `preco`, `id_externo_faturagil`, `limite_vagas`, `descricao`, `ativo`) VALUES
(1, 'Plano Básico', 49.90, '', 5, 'Ideal para pequenas empresas com poucas vagas por mês.', 1),
(2, 'Plano Profissional', 99.90, NULL, 20, 'Perfeito para empresas em crescimento com um volume maior de contratações.', 1),
(3, 'Plano Corporativo', 199.90, '', NULL, 'Vagas ilimitadas e suporte prioritário para grandes empresas.', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_candidato`
--

CREATE TABLE `respostas_candidato` (
  `id` int UNSIGNED NOT NULL,
  `candidatura_id` int UNSIGNED NOT NULL,
  `pergunta_id` int UNSIGNED NOT NULL,
  `resposta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_candidato`
--

INSERT INTO `respostas_candidato` (`id`, `candidatura_id`, `pergunta_id`, `resposta`) VALUES
(79, 135, 135, 'Sim'),
(84, 140, 136, 'Sim'),
(85, 140, 137, 'Sim'),
(86, 141, 136, 'Sim'),
(87, 141, 137, 'Sim'),
(90, 143, 142, 'Sim'),
(91, 143, 143, 'Sim');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kQfBpN6xjV3G18fnJ2dzrnj8XDfyH7cTcXMRg6ll', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTdFRTdWMFBJTURleGxGVnlFWWF1aEJjcGlFQ1Y5WElLZEI3T3ZveSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1758037342),
('xiWtk2VUp8p28dwiED0lWv2Rt9qZ1ZoLvZsuL1gL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicUZ6SG5WVG1IekVXRXlveGRhdVM3WG4welBEQWE2d3pUajduSkc1YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758037211);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `portal_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usuario` int NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Ativo, 0 = Inativo/Desligado',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_refresh_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `portal_id`, `name`, `email`, `cpf`, `email_verified_at`, `password`, `tipo_usuario`, `ativo`, `remember_token`, `google_refresh_token`, `created_at`, `updated_at`) VALUES
(11, 48, 'Ademar Admin', 'ademarteisen2004@gmail.com', NULL, NULL, '$2y$10$iIF.VFWYwwyKyt0Rl.8DpeJws74aWUfHDCnrCO1aE8.eB56lnRvzG', 3, 1, NULL, NULL, NULL, NULL),
(147, 59, 'Alberto', 'alberto.cruz.carvalho@gmail.com', NULL, NULL, '$2y$10$j7ewud5swQjOwP6.r9slAefp9jFSGoWECbKJQPSjIjdm3i3aoqcke', 2, 1, NULL, NULL, NULL, NULL),
(148, 59, 'Ademar de Araújo Teisen', 'ademarintalenti@gmail.com', '13130525904', NULL, '$2y$10$IifdWv1U9AFCyfIkFpYi5elzA.OcYkU.Oj4cITxnbiF0UcxJSkCtW', 1, 1, NULL, NULL, NULL, NULL),
(149, 59, 'ADEMAR JEFFERSON FERREIRA TEISEN', 'ademar2604@gmail.com', '02232964906', NULL, '$2y$10$hT1JAyTejbDSa7smmzxCLO3j1nwCPDsUb/mYJVrnu/a.pbdXQ4gmi', 1, 1, NULL, NULL, NULL, NULL),
(150, 59, 'Roberto', 'robertosanz2005@gmail.com', '65114081675', NULL, '$2y$10$oLmcTIUwBBhaFTdGeTk7G.GkDDTZ8JR3psze7C34uV2oMQeZm/3Xa', 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id` bigint UNSIGNED NOT NULL,
  `portal_id` int DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `recrutador_id` bigint UNSIGNED NOT NULL COMMENT 'ID do usuário (RH) que criou a vaga',
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_contrato` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modalidade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localizacao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `ramo_atividade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_vaga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experiencia` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requisitos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `faixa_salarial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faixa_salarial_min` decimal(10,2) DEFAULT NULL,
  `faixa_salarial_max` decimal(10,2) DEFAULT NULL,
  `salario_a_combinar` tinyint(1) DEFAULT '0',
  `beneficios` text COLLATE utf8mb4_unicode_ci,
  `confidencial` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id`, `portal_id`, `empresa_id`, `recrutador_id`, `titulo`, `tipo_contrato`, `modalidade`, `localizacao`, `cep`, `latitude`, `longitude`, `ramo_atividade`, `tipo_vaga`, `experiencia`, `descricao`, `requisitos`, `faixa_salarial`, `faixa_salarial_min`, `faixa_salarial_max`, `salario_a_combinar`, `beneficios`, `confidencial`, `created_at`, `updated_at`) VALUES
(120, 59, 60, 147, 'Vaga 1', 'Efetivo', 'Presencial', 'Maringá - PR', '87013-040', -23.4244234, -51.9330247, 'Serviços Gerais e Manutenção', '', 'indiferente', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', NULL, 1800.00, 3200.00, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, doloremque quisquam dolorem dolores ab voluptatem ducimus earum sapiente saepe deleniti hic. Sapiente praesentium eum iusto quidem molestiae voluptates doloribus dicta.', 0, '2026-01-15 19:48:20', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assinaturas_empresa` (`empresa_id`),
  ADD KEY `fk_assinaturas_plano` (`plano_id`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidatos_cpf_unique` (`cpf`),
  ADD KEY `candidatos_user_id_foreign` (`user_id`);

--
-- Índices de tabela `candidaturas`
--
ALTER TABLE `candidaturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_vaga_candidato` (`vaga_id`,`candidato_id`),
  ADD KEY `fk_candidaturas_candidato` (`candidato_id`),
  ADD KEY `idx_vaga_candidato` (`vaga_id`,`candidato_id`);

--
-- Índices de tabela `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidatura_id` (`candidatura_id`);

--
-- Índices de tabela `convites_empresa`
--
ALTER TABLE `convites_empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `empresa_id` (`empresa_id`),
  ADD KEY `criado_por_user_id` (`criado_por_user_id`);

--
-- Índices de tabela `cursos_complementares`
--
ALTER TABLE `cursos_complementares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidato_id` (`candidato_id`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresas_cnpj_unique` (`cnpj`);
ALTER TABLE `empresas` ADD FULLTEXT KEY `idx_fulltext_empresa` (`nome_empresa`);

--
-- Índices de tabela `empresa_user`
--
ALTER TABLE `empresa_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_user_empresa_id_foreign` (`empresa_id`),
  ADD KEY `empresa_user_user_id_foreign` (`user_id`);

--
-- Índices de tabela `experiencias_profissionais`
--
ALTER TABLE `experiencias_profissionais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exp_candidato` (`candidato_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `formacoes_academicas`
--
ALTER TABLE `formacoes_academicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_form_candidato` (`candidato_id`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `remetente_id` (`remetente_id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `perguntas_vaga`
--
ALTER TABLE `perguntas_vaga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaga_id` (`vaga_id`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `respostas_candidato`
--
ALTER TABLE `respostas_candidato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidatura_id` (`candidatura_id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vagas_recrutador_id` (`recrutador_id`),
  ADD KEY `fk_vagas_empresa_id` (`empresa_id`),
  ADD KEY `idx_portal_local` (`portal_id`,`localizacao`),
  ADD KEY `idx_portal_created` (`portal_id`,`created_at`);
ALTER TABLE `vagas` ADD FULLTEXT KEY `idx_fulltext_vagas` (`titulo`,`descricao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `candidaturas`
--
ALTER TABLE `candidaturas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de tabela `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `convites_empresa`
--
ALTER TABLE `convites_empresa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `cursos_complementares`
--
ALTER TABLE `cursos_complementares`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `empresa_user`
--
ALTER TABLE `empresa_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `experiencias_profissionais`
--
ALTER TABLE `experiencias_profissionais`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `formacoes_academicas`
--
ALTER TABLE `formacoes_academicas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `perguntas_vaga`
--
ALTER TABLE `perguntas_vaga`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `respostas_candidato`
--
ALTER TABLE `respostas_candidato`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `assinaturas`
--
ALTER TABLE `assinaturas`
  ADD CONSTRAINT `fk_assinaturas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assinaturas_plano` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`);

--
-- Restrições para tabelas `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `candidaturas`
--
ALTER TABLE `candidaturas`
  ADD CONSTRAINT `fk_candidaturas_candidato` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_candidaturas_vaga` FOREIGN KEY (`vaga_id`) REFERENCES `vagas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`candidatura_id`) REFERENCES `candidaturas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `convites_empresa`
--
ALTER TABLE `convites_empresa`
  ADD CONSTRAINT `convites_empresa_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `convites_empresa_ibfk_2` FOREIGN KEY (`criado_por_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `cursos_complementares`
--
ALTER TABLE `cursos_complementares`
  ADD CONSTRAINT `cursos_complementares_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `empresa_user`
--
ALTER TABLE `empresa_user`
  ADD CONSTRAINT `empresa_user_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `empresa_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `experiencias_profissionais`
--
ALTER TABLE `experiencias_profissionais`
  ADD CONSTRAINT `fk_exp_candidato` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `formacoes_academicas`
--
ALTER TABLE `formacoes_academicas`
  ADD CONSTRAINT `fk_form_candidato` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD CONSTRAINT `mensagens_chat_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagens_chat_ibfk_2` FOREIGN KEY (`remetente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `perguntas_vaga`
--
ALTER TABLE `perguntas_vaga`
  ADD CONSTRAINT `perguntas_vaga_ibfk_1` FOREIGN KEY (`vaga_id`) REFERENCES `vagas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas_candidato`
--
ALTER TABLE `respostas_candidato`
  ADD CONSTRAINT `respostas_candidato_ibfk_1` FOREIGN KEY (`candidatura_id`) REFERENCES `candidaturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_candidato_ibfk_2` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas_vaga` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `fk_vagas_empresa_id` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `fk_vagas_recrutador_id` FOREIGN KEY (`recrutador_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vagas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
