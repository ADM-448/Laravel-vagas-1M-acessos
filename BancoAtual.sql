-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 09/01/2026 às 21:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `intale75_multi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portal_id` int(11) DEFAULT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `tipo` enum('empresa','prefeitura') NOT NULL DEFAULT 'empresa',
  `status` enum('pendente','ativa','inativa') NOT NULL DEFAULT 'pendente',
  `cnpj` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `dominio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `portal_id`, `nome_empresa`, `nome_fantasia`, `tipo`, `status`, `cnpj`, `website`, `logo_path`, `ativo`, `created_at`, `updated_at`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `dominio`) VALUES
(32, 1, 'Intalenti Headhunter e Consultoria Ltda', 'IntalenTI Consult', 'empresa', 'pendente', '32806103000130', NULL, '32806103000130.png', 1, NULL, NULL, '87013100', 'Rua Piratininga', '916', 'Prédio', 'Zona 01', 'Maringá', 'PR', NULL),
(43, 1, 'ademarintalenti@gmail.com', NULL, 'empresa', '', '07097674000103', NULL, '07097674000103.jpeg', 1, NULL, NULL, '87043000', 'Avenida Guaiapó', '123', '', 'Jardim Oásis', 'Maringá', 'PR', ''),
(44, 1, 'Prefeitura Maringa', 'Prefeitura Maringa*', 'prefeitura', 'pendente', '76282656000106', NULL, '76282656000106.png', 1, NULL, NULL, '87013230', 'Avenida XV de Novembro', '1234', 'predio', 'Zona 01', 'Maringá', 'PR', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresas_cnpj_unique` (`cnpj`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
